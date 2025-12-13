<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    public function index()
    {
        return Iklan::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_iklan' => 'required',
            'biaya' => 'required|numeric',
            'biaya_pendaftaran' => 'required|numeric'
        ]);

        return Iklan::create($request->all());
    }

    public function show($id)
    {
        return Iklan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_iklan' => 'required|string',
            'biaya' => 'required|numeric',
            'biaya_pendaftaran' => 'required|numeric'
        ]);

        $iklan = Iklan::findOrFail($id);

        $iklan->nama_iklan = $request->input('nama_iklan');
        $iklan->biaya = $request->input('biaya');
        $iklan->biaya_pendaftaran = $request->input('biaya_pendaftaran');
        $iklan->save();

        return response()->json([
            'message' => 'Iklan berhasil diupdate',
            'data' => $iklan
        ]);
    }

    public function destroy($id)
    {
        Iklan::findOrFail($id)->delete();
        return response()->json(['message' => 'Iklan dihapus']);
    }
}
