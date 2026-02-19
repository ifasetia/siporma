<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load('profile');
        return view('pages.profile.index', [ // Arahkan ke folder pages/profile
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
{
    $user = Auth::user();
    $profile = $user->profile;

    // 1. Validasi yang lebih santai agar tidak gampang error
    $request->validate([
        'pr_nama' => 'required|string|max:255',
        'pr_no_hp' => 'nullable|string|max:20',
        'pr_status' => 'nullable|in:Aktif,Nonaktif',
        'pr_alamat' => 'nullable|string',
        'pr_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        // Sosmed kita buat string saja dulu biar aman
        'pr_instagram' => 'nullable|string',
        'pr_facebook' => 'nullable|string',
        'pr_linkedin' => 'nullable|string',
        'pr_github' => 'nullable|string',
        'pr_whatsapp' => 'nullable|string',
    ]);

    // 2. Data yang akan diupdate (PASTIKAN SEMUA FIELD MASUK DI SINI)
    $data = [
        'pr_nama' => $request->pr_nama,
        'pr_no_hp' => $request->pr_no_hp,
        'pr_status' => $request->pr_status,
        'pr_alamat' => $request->pr_alamat, // Pastikan ini ada
        'pr_jenis_kelamin' => $request->pr_jenis_kelamin, // Pastikan ini ada
        'pr_instagram' => $request->pr_instagram,
        'pr_linkedin' => $request->pr_linkedin,
        'pr_github' => $request->pr_github,
        'pr_whatsapp' => $request->pr_whatsapp,
        'pr_facebook' => $request->pr_facebook,
    ];

    // 3. Logika Upload Foto
    if ($request->hasFile('pr_photo')) {
        if ($profile->pr_photo && Storage::disk('public')->exists($profile->pr_photo)) {
            Storage::disk('public')->delete($profile->pr_photo);
        }
        $path = $request->file('pr_photo')->store('profiles', 'public');
        $data['pr_photo'] = $path;
    }

    // 4. Eksekusi Update ke Database
    $profile->update($data);

    // Update nama di table users agar sinkron
    $user->update(['name' => $request->pr_nama]);

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}
    // public function update(Request $request): RedirectResponse
    // {
    //     $user = Auth::user();
    //     $profile = $user->profile;

    //     // 1. Validasi
    //     // $request->validate([
    //     //     'pr_nama' => 'required|string|max:255',
    //     //     'pr_no_hp' => 'nullable|max:15',
    //     //     'pr_alamat' => 'nullable|string',
    //     //     'pr_jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
    //     //     'pr_tanggal_lahir' => 'nullable|date',
    //     //     'pr_status' => 'nullable|string|max:255',
    //     //     'pr_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
    //     //     'pr_instagram' => 'nullable|string|max:255',
    //     //     'pr_facebook' => 'nullable|string|max:255',
    //     //     'pr_linkedin' => 'nullable|string|max:255',
    //     //     'pr_whatsapp' => 'nullable|string|max:20',
    //     //     // Password
    //     //     'current_password' => ['nullable', 'current_password'],
    //     //     'password' => ['nullable', 'confirmed', Password::defaults()],
    //     // ]);

    //     // 2. Data yang akan diupdate
    //     $data = [
    //         'pr_nama' => $request->pr_nama,
    //         'pr_no_hp' => $request->pr_no_hp,
    //         'pr_alamat' => $request->pr_alamat,
    //         'pr_jenis_kelamin' => $request->pr_jenis_kelamin,
    //         'pr_tanggal_lahir' => $request->pr_tanggal_lahir,
    //         'pr_status' => $request->pr_status,

    //         'pr_instagram' => $request->pr_instagram,
    //         'pr_linkedin' => $request->pr_linkedin,
    //         'pr_github' => $request->pr_github,
    //         'pr_whatsapp' => $request->pr_whatsapp,
    //         'pr_facebook' => $request->pr_facebook,
    //     ];

    //     // 3. Logika Upload Foto
    //     if ($request->hasFile('pr_photo')) {
    //         // Hapus foto lama jika ada di storage
    //         if ($profile->pr_photo && Storage::disk('public')->exists($profile->pr_photo)) {
    //             Storage::disk('public')->delete($profile->pr_photo);
    //         }

    //         // Upload foto baru ke folder 'profiles' di storage/app/public
    //         $path = $request->file('pr_photo')->store('profiles', 'public');
    //         $data['pr_photo'] = $path;
    //     }

    //     $profile->update($data);

    //     // Update juga nama di table users agar sinkron
    //     $user->update(['name' => $request->pr_nama]);

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
