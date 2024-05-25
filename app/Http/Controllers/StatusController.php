<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index()
    {
       if (Auth::user()->role == 0) {
            $statuss = Photo::with('status')
            ->where('userId', auth()->id())
            ->orderByRaw('statusId = 4 DESC')
            ->get();

            return view('dashboard.member.foto.status', compact('statuss'));
       }else if(Auth::user()->role == 1){

        $statuss = Photo::with('status')
        ->orderByRaw('statusId = 4 DESC')
        ->get();

        $status  = Status::all();

        return view('dashboard.admin.foto.status', compact('statuss', 'status'));
       }
    }

    public function update(Request $request, $id)
    {
        $status = Photo::findOrFail($id);

        $request->validate([
            'statusId' => 'required|exists:status,id',
        ]);
        $status->update(['statusId' => $request->statusId]);

        return redirect()->back()->with('success', 'Berhasil Mengubah Status');
    }
}
