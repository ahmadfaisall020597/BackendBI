<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\Kalangan;
use App\Models\PesertaPendaftaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // TOTAL GLOBAL
        // =====================

        $totalBiayaIklan = Iklan::sum('biaya');
        $totalPendapatan = PesertaPendaftaran::sum('biaya_pendaftaran');
        $keuntungan = $totalPendapatan - $totalBiayaIklan;

        $laba = $totalBiayaIklan > 0
            ? ($keuntungan / $totalBiayaIklan) * 100
            : 0;

        // =====================
        // TOTAL PESERTA PER KALANGAN
        // =====================

        $kalanganStats = PesertaPendaftaran::select(
            'kalangan_id',
            'nama_kalangan',
            DB::raw('COUNT(*) as total_peserta')
        )
            ->groupBy('kalangan_id', 'nama_kalangan')
            ->get();

        // =====================
        // TOTAL PESERTA PER IKLAN
        // =====================
        $iklanStats = PesertaPendaftaran::join('iklans', 'peserta_pendaftarans.iklan_id', '=', 'iklans.id')
            ->select(
                'iklans.id as iklan_id',
                'iklans.nama_iklan',
                'iklans.biaya as biaya_iklan',

                DB::raw('COUNT(peserta_pendaftarans.id) as total_peserta'),
                DB::raw('SUM(peserta_pendaftarans.biaya_pendaftaran) as total_pendapatan'),
                DB::raw('COUNT(peserta_pendaftarans.id) * iklans.biaya as total_biaya_iklan'),
                DB::raw('SUM(peserta_pendaftarans.biaya_pendaftaran) - (COUNT(peserta_pendaftarans.id) * iklans.biaya) as keuntungan')
            )
            ->groupBy('iklans.id', 'iklans.nama_iklan', 'iklans.biaya')
            ->orderByDesc('total_peserta')
            ->limit(10)
            ->get();

        return response()->json([
            'summary' => [
                'total_biaya_iklan' => $totalBiayaIklan,
                'total_pendapatan' => $totalPendapatan,
                'keuntungan' => $keuntungan,
                'laba_persen' => round($laba, 2)
            ],
            'kalangan' => $kalanganStats,
            'iklan' => $iklanStats
        ]);
    }
}
