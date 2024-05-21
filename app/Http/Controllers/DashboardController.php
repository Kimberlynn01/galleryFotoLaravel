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
            $photos = Photo::where('userId', Auth::user()->id)->where('statusId' , 3)->get();

            return view('dashboard.member.dashboard', compact('photos'));
        }elseif (Auth::user()->role == '1') {
            $statusId1 = Photo::with('status' )->where('statusId', 1)->count();
            $statusId2 = Photo::with('status' )->where('statusId', 2)->count();
            $statusId3 = Photo::with('status' )->where('statusId', 3)->count();
            $statusId4 = Photo::with('status' )->where('statusId', 4)->count();

            $total = $statusId1 + $statusId2 + $statusId3 + $statusId4;

            return view('dashboard.admin.dashboard', compact('statusId1', 'statusId2', 'statusId3', 'statusId4', 'total'));
        }elseif (Auth::user()->role == '2') {
            return view('dashboard.superadmin.dashboard');
        }
    }
}
