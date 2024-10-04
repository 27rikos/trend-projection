<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Prediction;
use App\Models\Train;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PredictController extends Controller
{
    public function index()
    {
        $drugs = Obat::all();
        // Mengambil semua data prediksi dari database
        $prediksiData = Prediction::all();

        // Kembalikan data prediksi ke view tanpa data obat
        return view('admin.prediksi.index', [
            'prediksiData' => $prediksiData,
            'drugs' => $drugs,
        ]);
    }

    public function predicted(Request $request)
    {
        // Validasi input
        $request->validate([
            'obat' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $obat = $request->obat;
        $tanggal = Carbon::parse($request->tanggal);
        $tahunPrediksi = $tanggal->year;
        $tahunSebelumnya = $tahunPrediksi - 1;

        // Mendapatkan data penjualan obat berdasarkan nama obat yang dipilih
        $data = Train::where('obat', $obat)->orderBy('tanggal')->get();

        // Jika tidak ada data, kembalikan view dengan pesan error
        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data penjualan untuk obat ini tidak ditemukan.');
        }

        // Truncate tabel prediksi sebelum menyimpan data baru
        Prediction::truncate();

        // Menghitung komponen untuk trend projection
        $n = $data->count();
        $sumX = $data->sum('periode_x');
        $sumY = $data->sum('penjualan_y');
        $sumXY = $data->sum('xy');
        $sumX2 = $data->sum('x2');

        // Menghitung slope (m) dan intercept (b)
        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        // Ambil data aktual untuk tahun prediksi dan tahun sebelumnya
        $actualDataPrediksi = Train::where('obat', $obat)
            ->whereYear('tanggal', $tahunPrediksi)
            ->orderBy('tanggal')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('F');
            });

        $actualDataSebelumnya = Train::where('obat', $obat)
            ->whereYear('tanggal', $tahunSebelumnya)
            ->orderBy('tanggal')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('F');
            });

        $lastPeriodeX = $data->last()->periode_x;

        for ($month = 1; $month <= 12; $month++) {
            $currentPeriodeX = $lastPeriodeX + $month;
            $prediksiY = $intercept + $slope * $currentPeriodeX;

            $currentDate = Carbon::createFromDate($tahunPrediksi, $month, 1);
            $bulanTahun = $currentDate->format('F Y');
            $bulan = $currentDate->format('F');

            // Cek data aktual tahun prediksi, jika tidak ada gunakan data tahun sebelumnya
            if ($actualDataPrediksi->has($bulan)) {
                $aktualY = $actualDataPrediksi[$bulan]->penjualan_y;
            } elseif ($actualDataSebelumnya->has($bulan)) {
                $aktualY = $actualDataSebelumnya[$bulan]->penjualan_y;
            } else {
                $aktualY = null;
            }

            Prediction::create([
                'obat' => $obat,
                'bulan' => $bulanTahun,
                'prediksi_f' => round($prediksiY, 2),
                'periode_x' => $currentPeriodeX,
                'aktual_y' => $aktualY,
            ]);
        }

        // Redirect ke halaman index untuk menampilkan hasil prediksi
        return redirect()->route('predict.index')->with('success', 'Prediksi berhasil dihitung dan disimpan.');
    }

}