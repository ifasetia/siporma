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
use App\Models\Master\Kampus;
use App\Models\Master\Jurusan;
use App\Models\Master\Pekerjaan;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $kampusList = Kampus::all();
         // 🔥 INI YANG KURANG
        $jurusanList = Jurusan::all();
        $pekerjaanList = Pekerjaan::all();

        return view('pages.profile.index', [
            'user' => $user,
            'profile' => $user->profile,
            'kampusList' => $kampusList,// 🔥 KIRIM KE BLADE
            'jurusanList' => $jurusanList,
            'pekerjaanList' => $pekerjaanList,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->profile;

        // 1. Validasi umum
        $request->validate([
            'pr_nama' => 'required|string|max:255',
            'pr_no_hp' => 'nullable|string|max:20',
            'pr_status' => 'nullable|in:aktif,nonaktif',
            'pr_alamat' => 'nullable|string',
            'pr_jurusan' => 'nullable|exists:ms_jurusan,js_id',
            'pr_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pr_instagram' => 'nullable|string',
            'pr_facebook' => 'nullable|string',
            'pr_linkedin' => 'nullable|string',
            'pr_github' => 'nullable|string',
            'pr_whatsapp' => 'nullable|string',
            'pr_pekerjaan_id' => 'nullable|exists:ms_pekerjaan,pk_id_pekerjaan',
        ]);

        // 🔥 TAMBAHAN ROLE VALIDATION DI SINI
        if ($user->role === 'intern') {
            $request->validate([
                'pr_nim' => 'required|string|max:50',
                'pr_jurusan' => 'required|exists:ms_jurusan,js_id',
            ]);
        }

        if ($user->role === 'admin') {
            $request->validate([
                'pr_posisi' => 'required|string|max:255',
            ]);
        }

        // 2. Data yang akan diupdate
        $data = [
            'pr_nama' => $request->pr_nama,
            'pr_no_hp' => $request->pr_no_hp,
            'pr_status' => $request->pr_status,
            'pr_alamat' => $request->pr_alamat,
            'pr_jurusan' => $request->pr_jurusan,
            'pr_kampus_id' => $request->pr_kampus_id,
            'pr_jenis_kelamin' => $request->pr_jenis_kelamin,
            'pr_instagram' => $request->pr_instagram,
            'pr_linkedin' => $request->pr_linkedin,
            'pr_github' => $request->pr_github,
            'pr_whatsapp' => $request->pr_whatsapp,
            'pr_facebook' => $request->pr_facebook,
            'pr_pekerjaan_id' => $request->pr_pekerjaan_id,
            'pr_tanggal_lahir' => $request->pr_tanggal_lahir,
        ];

        // 🔥 TAMBAHAN ROLE FIELD DI SINI
        if ($user->role === 'intern') {
            $data['pr_nim'] = $request->pr_nim;
            $data['pr_jurusan'] = $request->pr_jurusan;
        }

        if ($user->role === 'admin') {
            $request->validate([
                'pr_nip' => 'required|string|max:50',
                'pr_posisi' => 'required|string|max:255',
            ]);

            $data['pr_nip'] = $request->pr_nip;
            $data['pr_posisi'] = $request->pr_posisi;
        }

        // 3. Upload Foto
        if ($request->hasFile('pr_photo')) {
            if ($profile->pr_photo && Storage::disk('public')->exists($profile->pr_photo)) {
                Storage::disk('public')->delete($profile->pr_photo);
            }
            $path = $request->file('pr_photo')->store('profiles', 'public');
            $data['pr_photo'] = $path;
        }

        // 4. Update database
        $profile->update($data);

        // Sinkron nama user
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
