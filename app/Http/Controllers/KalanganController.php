<?php

namespace App\Http\Controllers;

use App\Models\Kalangan;
use Illuminate\Http\Request;

class KalanganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $kalangan = Kalangan::when($search, function ($query, $search) {
            $query->where('nama_kalangan', 'like', '%' . $search . '%');
        })->get();

        return response()->json($kalangan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kalangan' => 'required|string|max:255'
        ]);

        $kalangan = Kalangan::create($request->only('nama_kalangan'));

        return response()->json([
            'message' => 'Kalangan berhasil ditambahkan',
            'data' => $kalangan
        ], 201);
    }

    public function show($id)
    {
        return response()->json(Kalangan::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kalangan' => 'required|string|max:255'
        ]);

        $kalangan = Kalangan::findOrFail($id);
        $kalangan->update($request->only('nama_kalangan'));

        return response()->json([
            'message' => 'Kalangan berhasil diupdate',
            'data' => $kalangan
        ]);
    }

    public function destroy($id)
    {
        Kalangan::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Kalangan berhasil dihapus'
        ]);
    }
}
