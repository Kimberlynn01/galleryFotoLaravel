<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == '0') {
            $photos = Photo::where('userId', Auth::user()->id)->get();

            return view('dashboard.member.dashboard', compact('photos'));
        }elseif (Auth::user()->role == '1') {

            return view('dashboard.admin.dashboard');
        }elseif (Auth::user()->role == '2') {
            return view('dashboard.superadmin.dashboard');
        }
    }
}
