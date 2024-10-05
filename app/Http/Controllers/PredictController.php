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

        // Mendapatkan data penjualan obat berdasarkan nama obat yang dipilih
        $data = Train::where('obat', $obat)->orderBy('tanggal')->get();

        // Jika tidak ada data, kembalikan dengan pesan error
        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data penjualan untuk obat ini tidak ditemukan.');
        }

        // Kosongkan tabel prediksi sebelum menyimpan data baru
        Prediction::truncate();

        // Menghitung slope dan intercept berdasarkan data yang ada
        $n = $data->count();
        $sumX = $data->sum('periode_x');
        $sumY = $data->sum('penjualan_y');
        $sumXY = $data->sum('xy');
        $sumX2 = $data->sum('x2');

        // Menghitung slope dan intercept
        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        // Ambil data aktual hanya untuk tahun prediksi
        $actualDataPrediksi = Train::where('obat', $obat)
            ->whereYear('tanggal', $tahunPrediksi)
            ->orderBy('tanggal')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('F');
            });

        // Mengambil periode X terakhir dari data aktual
        $lastPeriodeX = $data->last()->periode_x;

        // Loop untuk memprediksi penjualan untuk 12 bulan ke depan
        for ($month = 1; $month <= 12; $month++) {
            // Menghitung periode X yang bertambah setiap bulan dari periode terakhir
            $currentPeriodeX = $lastPeriodeX + $month;

            // Menghitung prediksi penjualan Y
            $prediksiY = $intercept + $slope * $currentPeriodeX;

            // Mengatur tanggal untuk bulan saat ini
            $currentDate = Carbon::createFromDate($tahunPrediksi, $month, 1);
            $bulanTahun = $currentDate->format('F Y');
            $bulan = $currentDate->format('F');

            // Cek data aktual untuk bulan tersebut di tahun prediksi
            $aktualY = $actualDataPrediksi->has($bulan) ? $actualDataPrediksi[$bulan]->penjualan_y : null;

            // Simpan prediksi ke database
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
