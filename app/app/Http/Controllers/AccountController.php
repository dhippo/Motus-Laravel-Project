<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/app/Http/Controllers/AccountController.php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Avatar;

class AccountController extends Controller
{
    public function showAccount()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('account.edit', compact('user'));
    }

    public function update(UpdateAccountRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());
        return redirect()->route('account')->with('success', 'Informations mises à jour.');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Valider le fichier image
        ]);

        $user = Auth::user();
        $path = $request->file('avatar')->store('avatars', 'public'); // Stocker l'image dans storage/app/public/avatars

        Avatar::updateOrCreate(['user_id' => $user->id], ['path' => $path]);

        return redirect()->back()->with('success', 'Photo de profil mise à jour.');
    }


}

