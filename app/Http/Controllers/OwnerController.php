<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkirTransaksi;
use Carbon\Carbon;

class OwnerController extends Controller
{
    /**
     * Dashboard Owner - Menampilkan laporan dan statistik
     */
    public function dashboard(Request $request)
    {
        // Ambil date dari query parameter, default adalah hari ini
        $date = $request->query('date') ? Carbon::parse($request->query('date')) : now();
        $dateStart = $date->copy()->startOfDay();
        $dateEnd = $date->copy()->endOfDay();

        // Statistik kendaraan sedang parkir (status IN)
        $sedangParkir = ParkirTransaksi::where('status', 'IN')->count();

        // Total transaksi selesai hari ini
        $totalTransaksiHariIni = ParkirTransaksi::where('status', 'DONE')
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->count();

        // Pendapatan hari ini
        $pendapatanHariIni = ParkirTransaksi::where('status', 'DONE')
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->sum('fee');

        // Transaksi hari ini (untuk detail table)
        $transaksiHariIni = ParkirTransaksi::whereBetween('created_at', [$dateStart, $dateEnd])
            ->latest('created_at')
            ->get();

        // Total transaksi selesai (all time)
        $totalTransaksiSelesai = ParkirTransaksi::where('status', 'DONE')->count();

        // Total pendapatan (all time)
        $totalPendapatan = ParkirTransaksi::where('status', 'DONE')->sum('fee');

        // Total jam parkir (all time)
        $totalJamParkir = ParkirTransaksi::where('status', 'DONE')->sum('duration') ?? 0;

        // Rata-rata durasi parkir
        $rataRataDurasi = $totalTransaksiSelesai > 0 
            ? round($totalJamParkir / $totalTransaksiSelesai, 1)
            : 0;

        // Rata-rata pendapatan per jam
        $rataRataPendapatan = $totalJamParkir > 0 
            ? round($totalPendapatan / $totalJamParkir, 0)
            : 0;

        return view('owner.dashboard', [
            'sedangParkir'              => $sedangParkir,
            'totalTransaksiHariIni'     => $totalTransaksiHariIni,
            'pendapatanHariIni'         => $pendapatanHariIni ?? 0,
            'transaksiHariIni'          => $transaksiHariIni,
            'totalTransaksiSelesai'     => $totalTransaksiSelesai,
            'totalPendapatan'           => $totalPendapatan ?? 0,
            'totalJamParkir'            => $totalJamParkir,
            'rataRataDurasi'            => $rataRataDurasi,
            'rataRataPendapatan'        => $rataRataPendapatan,
        ]);
    }
}