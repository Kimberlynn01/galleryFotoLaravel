<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{
    public function index()
    {
        $albums = Album::where("userId", Auth::user()->id)->get();
        return view('dashboard.member.foto.index', compact('albums'));
    }

    public function form()
    {
        $albums = Album::where("userId", Auth::user()->id)->get();
        return view('dashboard.member.foto.form', compact('albums'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_foto' => 'required',
            'deskripsi_foto' => 'required',
            'lokasifoto' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'albumId' => 'required|exists:album,id',
        ]);

        if ($request->hasFile('lokasifoto')) {
            $imagePath = $request->file('lokasifoto')->store('foto_Foto', 'public');
            $validate['lokasifoto'] = $imagePath;
        }

        Photo::create([
            'nama_foto' => $validate['nama_foto'],
            'deskripsi_foto' => $validate['deskripsi_foto'],
            'albumId' => $validate['albumId'],
            'userId' => Auth::user()->id,
            'lokasifoto' => $validate['lokasifoto'],
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Successfully add photo.');
    }
}
