<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    public function index()
    {
        return response()->json(Webinar::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_webinar' => 'required|string|max:255'
        ]);

        $webinar = Webinar::create($request->only('nama_webinar'));

        return response()->json([
            'message' => 'Webinar berhasil ditambahkan',
            'data' => $webinar
        ], 201);
    }

    public function show($id)
    {
        return response()->json(Webinar::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_webinar' => 'required|string|max:255'
        ]);

        $webinar = Webinar::findOrFail($id);
        $webinar->update($request->only('nama_webinar'));

        return response()->json([
            'message' => 'Webinar berhasil diupdate',
            'data' => $webinar
        ]);
    }

    public function destroy($id)
    {
        Webinar::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Webinar berhasil dihapus'
        ]);
    }
}
