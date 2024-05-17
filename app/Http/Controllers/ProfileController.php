<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == '1') {

            return view('dashboard.admin.template.profile');
        }else if(Auth::user()->role == '2') {
            return view('dashboard.superadmin.template.profile');
        }else{
            return view('dashboard.member.template.profile');
        }

    }



    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email', // Menghapus aturan 'unique' dan menambahkan aturan email
            'old_password' => 'required|string',
            'password' => 'nullable|string|min:2',
            'picture' => 'nullable|image',
        ]);

        if ($request->filled('old_password') && !Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.'])->withInput();
        }

        // Memperbarui nama jika diisi
        $user->name = $request->input('name');

        // Memperbarui email hanya jika ada perubahan
        if ($request->input('email') && $request->input('email') !== $user->email) {
            $user->email = $request->input('email');
            // Validasi email unik hanya jika ada perubahan email
            $request->validate([
                'email' => 'unique:users,email', // Aturan validasi unik hanya saat email diubah
            ], [
                'email.unique' => 'The email has already been taken.',
            ]);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('profile_pictures', 'public');
            $user->picture = $imagePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }



}
