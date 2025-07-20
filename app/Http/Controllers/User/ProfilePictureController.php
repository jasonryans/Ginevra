<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePictureController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('user.profile.picture.edit', compact('user'));
    }

    public function update(Request $request)
    {
        try {
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
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $file = $request->file('profile_picture');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            // Update the user's profile_picture
            $user->profile_picture = $path;
            $user->save();

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture updated successfully!',
                    'profile_picture_url' => Storage::url($path)
                ]);
            }

            return redirect()->route('user.profile.index')->with('status', 'Foto profil berhasil diperbarui.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            // Handle other errors
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while uploading the profile picture: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->withErrors(['profile_picture' => 'An error occurred while uploading the profile picture.']);
        }
    }
}