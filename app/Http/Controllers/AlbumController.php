<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::where('userId', Auth::user()->id)->get();

        return view('dashboard.member.album.index', compact('albums'));
    }

    public function form()
    {
        return view('dashboard.member.album.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_album' => 'required',
            'deskripsi_album' => 'required',
            'thumbnail_album' => 'required|image',
        ]);

        $album = new Album();
        $album->userId = auth()->id();
        $album->nama_album = $request->nama_album;
        $album->deskripsi_album = $request->deskripsi_album;
        if ($request->hasFile('thumbnail_album')) {
            $imagePath = $request->file('thumbnail_album')->store('thumbnail_album', 'public');
            $album->thumbnail_album = $imagePath;
        }
        $album->save();

        return redirect()->route('album.index')->with('success', 'Album created successfully.');
    }

    public function delete($id)
    {
        $album = Album::findOrFail($id);

        if ($album->userId !== auth()->id()) {
            return redirect()->route('album.index')->withErrors('You don\'t have permission to delete this album.');
        }

        if($album->thumbnail_album){
            \Storage::disk('public')->delete($album->thumbnail_album);
        }

        $album->delete();

        return redirect()->route('album.index')->with('success2', 'Album deleted successfully.');
    }

    public function update($id, Request $request)
    {

        $album = Album::findOrFail($id);

        if ($album->userId !== auth()->id()) {
            return redirect()->route('album.index')->withErrors('You don\'t have permission to update this album.');
        }

        $album->nama_album = $request->nama_album;
        $album->deskripsi_album = $request->deskripsi_album;

        if ($request->hasFile('thumbnail_album')) {
            // Delete old thumbnail if exists
            if ($album->thumbnail_album) {
                \Storage::disk('public')->delete($album->thumbnail_album);
            }

            $imagePath = $request->file('thumbnail_album')->store('thumbnail_album', 'public');
            $album->thumbnail_album = $imagePath;
        }

        $album->save();

        return redirect()->route('album.index')->with('success', 'Album updated successfully.');
    }

}
