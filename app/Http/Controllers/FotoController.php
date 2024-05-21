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
        $photos = Photo::with('status')->where("userId", Auth::user()->id)->get();



        return view('dashboard.member.foto.index', compact('photos'));
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
        ]);

        if ($request->hasFile('lokasifoto')) {
            $imagePath = $request->file('lokasifoto')->store('foto_Foto', 'public');
            $validate['lokasifoto'] = $imagePath;
        }

        Photo::create([
            'nama_foto' => $validate['nama_foto'],
            'deskripsi_foto' => $validate['deskripsi_foto'],
            'userId' => Auth::user()->id,
            'lokasifoto' => $validate['lokasifoto'],
            'statusId' => 1,
        ]);

        return redirect()->route('foto.index')->with('success', 'Successfully add photo.');
    }
}
