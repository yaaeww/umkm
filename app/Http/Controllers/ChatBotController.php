<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use App\Models\Umkm;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log; // Import Facade Log

class ChatBotController extends Controller
{
    // Menampilkan halaman chatbot
    public function index()
    {
        return view('chatbot.index');
    }

    // Menghandle chat AJAX
    public function chat(Request $request)
    {
        $message = $request->input('message');

        // Special flag untuk polling chat realtime
        if ($message === '__load_history__') {
            if (Auth::check()) {
                $chats = Chat::where('user_id', Auth::id())->latest()->take(50)->get()->reverse();
                $history = $chats->map(fn($chat) => [
                    'message' => $chat->message,
                    'reply' => $chat->reply,
                ])->toArray();
                return response()->json(['history' => $history]);
            }
            return response()->json(['history' => []]);
        }

        $messageLower = strtolower($message);
        $replyParts = [];

        // Pisahkan kalimat berdasarkan koma, "dan", "atau"
        $segments = preg_split('/,| dan | atau /', $messageLower);

        foreach ($segments as $segment) {
            $segment = trim($segment);

            if (Str::contains($segment, ['halo', 'hai', 'hello', 'hi'])) {
                $replyParts[] = "Halo 👋! Saya Asisten UMKM Indramayu. Mau lihat produk, cek pesanan, atau tanya promo?";
            }
            elseif (Str::contains($segment, ['produk', 'barang', 'jual'])) {
                $produkList = Produk::take(3)->get();
                if ($produkList->count()) {
                    $res = "Berikut 3 produk populer UMKM:\n";
                    foreach ($produkList as $p) {
                        $umkm = optional(Umkm::find($p->umkm_id));
                        $res .= "• {$p->nama} - Rp " . number_format($p->harga, 0, ',', '.') . "\n";
                        $res .= "  Toko: " . ($umkm->nama_toko ?? '-') . "\n";
                        $res .= "  Stok: {$p->stok}\n";
                    }
                    $replyParts[] = $res;
                } else {
                    $replyParts[] = "Saat ini belum ada produk yang tersedia 😔";
                }
            }
            elseif (Str::contains($segment, ['pesanan', 'order', 'belanja'])) {
                if (Auth::check()) {
                    $order = Order::where('user_id', Auth::id())->latest()->first();
                    if ($order) {
                        $produk = optional(Produk::find($order->produk_id));
                        $res = "Pesanan terbaru kamu #{$order->id}\n";
                        $res .= "Produk: " . ($produk->nama ?? '-') . "\n";
                        $res .= "Total Harga: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n";
                        $res .= "Status: {$order->status}\n";
                        $res .= "Status Pesanan: " . ($order->status_pesanan ?? '-') . "\n";
                        $replyParts[] = $res;
                    } else {
                        $replyParts[] = "Kamu belum punya pesanan. Yuk belanja produk UMKM!";
                    }
                } else {
                    $replyParts[] = "Silakan login dulu untuk cek status pesanan.";
                }
            }
            elseif (Str::contains($segment, ['toko', 'umkm', 'penjual'])) {
                $umkms = Umkm::take(3)->get();
                if ($umkms->count()) {
                    $res = "Berikut beberapa UMKM di Indramayu:\n";
                    foreach ($umkms as $u) {
                        $res .= "• {$u->nama_toko}\n";
                        $res .= "  Alamat: {$u->alamat}\n";
                        $res .= "  Telp: " . ($u->no_telp ?? '-') . "\n";
                    }
                    $replyParts[] = $res;
                } else {
                    $replyParts[] = "Belum ada UMKM yang terdaftar 😔";
                }
            }
            elseif (Str::contains($segment, ['promo', 'diskon', 'penawaran'])) {
                $replyParts[] = "Ada promo 🎉 Diskon 10% untuk semua produk sampai akhir bulan ini.";
            }
            elseif (Str::contains($segment, ['terima kasih', 'makasih'])) {
                $replyParts[] = "Sama-sama 😊 Senang bisa membantu!";
            }
        }

        // Jika tidak ada keyword yang cocok, panggil API Gemini
        if (empty($replyParts)) {
            $replyParts[] = $this->askGemini($message);
        }

        $reply = implode("\n\n", $replyParts);

        // Simpan chat ke database
        if (Auth::check()) {
            Chat::create([
                'user_id' => Auth::id(),
                'message' => $message,
                'reply' => $reply,
            ]);
        }

        // Pastikan reply diubah ke nl2br agar format baris baru HTML tetap valid
        return response()->json(['reply' => nl2br($reply)]);
    }

    /**
     * Fungsi untuk memanggil Gemini API dengan logging.
     */
    protected function askGemini(string $prompt): string
    {
        $modelName = env('GEMINI_MODEL_NAME', 'gemini-2.5-flash');
        Log::info("DEBUG: Mencoba memanggil Gemini dengan model: " . $modelName);
        Log::info("DEBUG: Prompt user: " . $prompt);

        try {
            // Ambil riwayat chat (jika ada) untuk memberikan konteks percakapan
            $history = [];
            
            // Tambahkan instruksi sistem
            $history[] = [
                'role' => 'system',
                'parts' => [['text' => 'Anda adalah Asisten Virtual yang ramah, berpengetahuan luas, dan fokus pada informasi tentang UMKM di Indramayu. Jika pertanyaan tidak terkait UMKM, jawab dengan bahasa yang santai dan informatif.']]
            ];

            if (Auth::check()) {
                $chats = Chat::where('user_id', Auth::id())->latest()->take(10)->get()->reverse();
                
                foreach ($chats as $chat) {
                    $history[] = ['role' => 'user', 'parts' => [['text' => $chat->message]]];
                    if ($chat->reply) {
                        // Hilangkan tag HTML <br> dan konversi ke new line (\n) sebelum dikirim ke API
                        $cleanedReply = strip_tags(str_replace('<br />', "\n", $chat->reply));
                        $history[] = ['role' => 'model', 'parts' => [['text' => $cleanedReply]]];
                    }
                }
            }
            
            // Tambahkan prompt user saat ini
            $history[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];

            Log::debug('DEBUG: History payload yang dikirim ke Gemini:', $history);

            // Panggil Gemini API
            $result = Gemini::generativeModel(model: $modelName)
                            ->generateContent($history);

            // Cek apakah response sukses dan ambil teksnya
            if ($result->text) {
                Log::info("DEBUG: Balasan Gemini berhasil diterima.");
                return $result->text;
            } else {
                Log::warning("DEBUG: Gemini mengembalikan properti teks kosong.", ['response_dump' => json_encode($result)]);
                return 'Maaf, respons AI tidak memberikan balasan teks yang valid. (Kode: 001)';
            }

        } catch (\Exception $e) {
            // Log error lengkap
            Log::error('FATAL ERROR: Gemini API error (Exception caught): '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'prompt' => $prompt
            ]);

            // Beri pesan error yang informatif kepada pengguna
            if (Str::contains($e->getMessage(), ['API key', 'authentication'])) {
                 return 'Maaf, Kunci API Gemini tidak valid atau belum terkonfigurasi. Silakan periksa file .env Anda. (Kode: 401)';
            }

            return 'Maaf, terjadi kesalahan teknis saat menghubungi AI. (Kode: 500)';
        }
    }
}
