<?php

namespace App\Http\Controllers;

use App\Models\PesertaPendaftaran;
use App\Models\Kalangan;
use App\Models\Iklan;
use App\Models\Webinar;
use Illuminate\Http\Request;

class PesertaPendaftaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kalangan_id' => 'required|exists:kalangans,id',
            'iklan_id' => 'required|exists:iklans,id',
            'webinar_id' => 'required|exists:webinars,id',
            'biaya_pendaftaran' => 'required|numeric'
        ]);

        // ❌ CEK DUPLIKAT
        $sudahDaftar = PesertaPendaftaran::where('user_id', auth()->id())
            ->where('kalangan_id', $request->kalangan_id)
            ->where('iklan_id', $request->iklan_id)
            ->where('webinar_id', $request->webinar_id)
            ->exists();

        if ($sudahDaftar) {
            return response()->json([
                'message' => 'Anda sudah terdaftar pada kalangan, iklan, dan webinar ini'
            ], 422);
        }

        $kalangan = Kalangan::findOrFail($request->kalangan_id);
        $iklan = Iklan::findOrFail($request->iklan_id);
        $webinar = Webinar::findOrFail($request->webinar_id);

        $peserta = PesertaPendaftaran::create([
            'user_id' => auth()->id(),
            'kalangan_id' => $kalangan->id,
            'iklan_id' => $iklan->id,
            'webinar_id' => $webinar->id,
            'nama_peserta' => auth()->user()->name,
            'nama_kalangan' => $kalangan->nama_kalangan,
            'nama_iklan' => $iklan->nama_iklan,
            'nama_webinar' => $webinar->nama_webinar,
            'biaya_pendaftaran' => $request->biaya_pendaftaran
        ]);

        return response()->json([
            'message' => 'Pendaftaran berhasil',
            'data' => $peserta
        ], 201);
    }

    public function index()
    {
        return PesertaPendaftaran::where('user_id', auth()->id())->get();
    }

    public function listUser()
    {
        $data = PesertaPendaftaran::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data);
    }


    public function listAll()
    {
        $data = PesertaPendaftaran::orderBy('created_at', 'desc')->get();

        return response()->json($data);
    }
}
