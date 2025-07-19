<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilePictureController extends Controller
{
    function edit(Request $request)
    {
        $user = $request->user();
        return view('user.profile.picture.edit', compact('user'));
    }

    function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_picture.required' => 'Foto profil wajib dipilih.',
            'profile_picture.image' => 'File harus berupa gambar.',
            'profile_picture.mimes' => 'Format file harus jpeg, png, jpg, atau gif.',
            'profile_picture.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $user = $request->user();
        
        // Delete old profile picture if exists
        if ($user->profile_picture && file_exists(storage_path('app/public/' . $user->profile_picture))) {
            unlink(storage_path('app/public/' . $user->profile_picture));
        }
        
        $file = $request->file('profile_picture');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profile_pictures', $filename, 'public');

        // Update the user's profile_picture
        $user->profile_picture = $path;
        $user->save();

        return redirect()->route('user.profile.index')->with('status', 'Foto profil berhasil diperbarui.');
    }
}
