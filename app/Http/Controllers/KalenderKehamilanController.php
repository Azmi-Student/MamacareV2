<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\KehamilanMama;
use Carbon\Carbon;

class KalenderKehamilanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dataKehamilan = $user->kehamilan;
        $hphtInput = $request->query('hpht');

        // Simpan HPHT jika baru pertama kali input
        if (!$dataKehamilan && $hphtInput) {
            $dataKehamilan = KehamilanMama::create([
                'user_id' => $user->id,
                'hpht' => $hphtInput
            ]);
        }

        $hphtFinal = $dataKehamilan ? $dataKehamilan->hpht : $hphtInput;

        if (!$hphtFinal) {
            return view('page.kalender-kehamilan.index', ['data' => null]);
        }

        try {
            $stats = $this->hitungProgress($hphtFinal);

            // --- LOGIKA CACHING (HEMET API) ---
            if ($dataKehamilan && $dataKehamilan->ai_data) {
                $cachedData = json_decode($dataKehamilan->ai_data, true);
                
                // Jika minggu masih sama, ambil dari DB (0 API CALL)
                if (isset($cachedData['minggu_cache']) && $cachedData['minggu_cache'] == $stats['minggu']) {
                    return view('page.kalender-kehamilan.index', [
                        'data' => array_merge($stats, $cachedData, ['hpht' => $hphtFinal])
                    ]);
                }
            }

            // --- JIKA TIDAK ADA CACHE / MINGGU BERGANTI: PANGGIL MEGA API ---
            $aiResponse = $this->generateMegaAI($stats['minggu']);

            // Jika AI Gagal, pakai data cadangan agar tidak error merah
            if (!$aiResponse) {
                $aiResponse = $this->fallbackData();
            }

            $dataUntukSimpan = array_merge(['minggu_cache' => $stats['minggu']], $aiResponse);

            // Simpan hasil Mega AI ke Database
            if ($dataKehamilan) {
                $dataKehamilan->update(['ai_data' => json_encode($dataUntukSimpan)]);
            }

            return view('page.kalender-kehamilan.index', [
                'data' => array_merge($stats, $dataUntukSimpan, ['hpht' => $hphtFinal])
            ]);

        } catch (\Exception $e) {
            return redirect()->route('mama.kalender');
        }
    }

    public function detail(Request $request)
    {
        $user = Auth::user();
        $dataKehamilan = $user->kehamilan;
        $hpht = $dataKehamilan ? $dataKehamilan->hpht : $request->query('hpht');

        if (!$hpht) return redirect()->route('mama.kalender');

        try {
            $stats = $this->hitungProgress($hpht);

            // --- KUNCI MATI: DETAIL HARUS AMBIL DARI DATABASE ---
            if ($dataKehamilan && $dataKehamilan->ai_data) {
                $cachedData = json_decode($dataKehamilan->ai_data, true);
                
                // Jika cache cocok dengan minggu ini, tampilkan (0 API CALL)
                if (isset($cachedData['minggu_cache']) && $cachedData['minggu_cache'] == $stats['minggu']) {
                    return view('page.kalender-kehamilan.detail', [
                        'data' => array_merge($stats, $cachedData, ['hpht' => $hpht])
                    ]);
                }
            }

            // Jika cache bocor/kosong (jarang terjadi), panggil ulang & simpan lagi
            $aiResponse = $this->generateMegaAI($stats['minggu']) ?? $this->fallbackData();
            if ($dataKehamilan) {
                $dataKehamilan->update(['ai_data' => json_encode(array_merge(['minggu_cache' => $stats['minggu']], $aiResponse))]);
            }

            return view('page.kalender-kehamilan.detail', [
                'data' => array_merge($stats, $aiResponse, ['hpht' => $hpht])
            ]);

        } catch (\Exception $e) {
            return redirect()->route('mama.kalender');
        }
    }

    private function hitungProgress($hpht)
    {
        $tanggal_hpht = Carbon::parse($hpht);
        $hari_ini = Carbon::now();
        $total_hari = $tanggal_hpht->diffInDays($hari_ini);
        $minggu = floor($total_hari / 7);
        $hari = $total_hari % 7;
        $hpl = Carbon::parse($hpht)->addDays(280);
        $sisa_hari = ceil($hari_ini->diffInSeconds($hpl) / 86400);
        $trimester = ($minggu >= 28) ? 3 : (($minggu >= 13) ? 2 : 1);

        return [
            'minggu' => $minggu,
            'hari' => $hari,
            'hpl' => $hpl->translatedFormat('d F Y'),
            'sisa_hari' => $sisa_hari > 0 ? $sisa_hari : 0,
            'trimester' => $trimester,
            'persen' => min(100, round(($total_hari / 280) * 100))
        ];
    }

    /**
     * MEGA PROMPT: Sekali tarik dapat semua data
     */
    private function generateMegaAI($minggu)
{
    $prompt = "Bertindaklah sebagai pakar kehamilan Mamacare. Berikan laporan komprehensif minggu ke-{$minggu} untuk Ibu hamil dalam Bahasa Indonesia.
    
    ATURAN WAJIB:
    1. Output HARUS JSON murni tanpa teks pembuka/penutup dan tanpa markdown (```json).
    2. Semua poin list harus menyertakan contoh konkret di dalam kurung ().
    3. Isi list minimal 3 poin per kategori agar data tidak kosong.
    
    STRUKTUR JSON:
    {
        \"ukuran\": \"seukuran buah/benda (misal: Jeruk Nipis)\",
        \"tips\": \"1 tips kesehatan mental/fisik paling relevan minggu ini\",
        \"detail\": \"perkembangan organ utama janin saat ini (misal: jantung mulai berdetak)\",
        \"harian\": [\"aktivitas rutin (contoh: jalan pagi 15 menit)\", \"...\"],
        \"mingguan\": [\"checklist minggu ini (contoh: cek berat badan)\", \"...\"],
        \"bulanan\": [\"persiapan besar (contoh: booking jadwal USG)\", \"...\"],
        \"rekomendasi\": [\"nutrisi wajib (contoh: asam folat dari alpukat)\", \"...\"],
        \"hindari\": [\"pantangan keras (contoh: daging mentah/sushi)\", \"...\"]
    }";

    return $this->callGemini($prompt);
}

    /**
     * Data Cadangan jika AI Error
     */
    private function fallbackData()
    {
        return [
            'ukuran' => 'Sedang tumbuh',
            'tips' => 'Jaga kesehatan dan istirahat cukup ya Ma!',
            'detail' => 'Janin sedang berkembang dengan baik minggu ini.',
            'harian' => ['Minum air putih 2-3 Liter', 'Makan buah/sayur'],
            'mingguan' => ['Olahraga ringan pagi'],
            'bulanan' => ['Cek jadwal kontrol dokter'],
            'rekomendasi' => ['Asam folat', 'Protein'],
            'hindari' => ['Stres berlebih', 'Angkat beban berat']
        ];
    }

    private function callGemini($prompt)
    {
        $apiKeys = explode(',', env('GEMINI_API_KEYS', ''));
        foreach ($apiKeys as $key) {
            $key = trim($key);
            if (empty($key)) continue;

            try {
                $response = Http::withHeaders([
                    'x-goog-api-key' => $key,
                    'Content-Type' => 'application/json',
                ])->timeout(20)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent", [
                    "contents" => [["parts" => [["text" => $prompt]]]]
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $text = $json['candidates'][0]['content']['parts'][0]['text'];
                    $cleanJson = trim(str_replace(['```json', '```'], '', $text));
                    return json_decode($cleanJson, true);
                }
            } catch (\Exception $e) { continue; }
        }
        return null;
    }

    public function reset() 
    { 
        $user = Auth::user();
        if ($user->kehamilan) $user->kehamilan->delete();
        return redirect()->route('mama.kalender'); 
    }
    /**
     * Update status checklist harian ke database (JSON)
     */
    public function updateChecklist(Request $request)
    {
        $user = Auth::user();
        $dataKehamilan = $user->kehamilan;

        if (!$dataKehamilan || !$dataKehamilan->ai_data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        try {
            // 1. Decode data AI yang sudah ada
            $aiData = json_decode($dataKehamilan->ai_data, true);
            
            // 2. Ambil input dari Fetch/AJAX
            $index = $request->input('index');
            $isChecked = $request->input('checked');

            // 3. Siapkan atau update key 'checklist_status'
            // Kita simpan dalam bentuk array asosiatif: [index => true/false]
            $currentStatus = $aiData['checklist_status'] ?? [];
            $currentStatus[$index] = $isChecked;
            
            $aiData['checklist_status'] = $currentStatus;

            // 4. Simpan kembali ke database dalam bentuk JSON
            $dataKehamilan->update([
                'ai_data' => json_encode($aiData)
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}