<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $obat = Obat::count();
        $type = Obat::distinct('jenis')->count('jenis');
        $sale = Sale::count();
        $obats = Obat::select('jenis', DB::raw('COUNT(*) as total_jumlah'))
            ->groupBy('jenis')
            ->get();
        $sales = Sale::all();
        return view('admin.dashboard.index', compact('obat', 'type', 'sale', 'obats', 'sales'));
    }
}