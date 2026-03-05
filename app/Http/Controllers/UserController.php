<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $user = User::latest()->paginate(10);
        return view('pages.user.index', compact('user'));
    }

    public function datatable(Request $request)
    {
        $query = User::with('profile')->latest();

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('foto', function ($row) {

                if ($row->profile && $row->profile->pr_photo) {
                    return '<img src="'.asset('storage/'.$row->profile->pr_photo).'"
                            class="w-10 h-10 rounded-full object-cover">';
                }

                return '<div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">'
                    . strtoupper(substr($row->name,0,1)) .
                '</div>';
            })

            ->addColumn('pr_nama', function ($row) {
                return $row->profile->pr_nama ?? $row->name;
            })

            ->addColumn('pr_no_hp', function ($row) {
                return $row->profile->pr_no_hp ?? '-';
            })

            ->addColumn('foto', function ($row) {

                if ($row->profile && $row->profile->pr_photo) {
                    return '<img src="'.asset('storage/'.$row->profile->pr_photo).'"
                            class="w-10 h-10 rounded-full object-cover">';
                }

                return '<div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">'
                    . strtoupper(substr($row->name,0,1)) .
                '</div>';
            })

            ->addColumn('pr_nama', function ($row) {
                return $row->profile->pr_nama ?? '-';
            })

            ->addColumn('pr_no_hp', function ($row) {
                return $row->profile->pr_no_hp ?? '-';
            })

            ->addColumn('pr_posisi', function ($row) {
                return $row->profile->pr_posisi ?? '-';
            })

            ->addColumn('status', function ($row) {
                return $row->profile->pr_status ?? 'Menunggu';
            })

            ->addColumn('detail', function ($row) {
                return '<button class="btn-detail text-blue-600" data-id="'.$row->id.'">Detail</button>';
            })

            ->addColumn('aksi', function ($row) {
                return '
                <div class="flex items-center justify-center gap-1.5">

                    <!-- EDIT -->
                    <button
                        type="button"
                        data-id="'.$row->id.'"
                        class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                        </svg>

                        Edit
                    </button>

                    <!-- DELETE -->
                    <button
                        type="button"
                        data-id="'.$row->id.'"
                        class="btn-delete inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 7h12M9 7V5h6v2m-7 0l1 12h8l1-12"/>
                        </svg>

                        Hapus
                    </button>

                </div>';
            })


            ->rawColumns(['foto','detail','aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ], [
            // Tulis pesan kustom di sini
            'name.required'     => 'Nama user wajib diisi',
            'email.required'    => 'Email user wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 8 karakter',
            'role.required'     => 'Role wajib dipilih',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diupdate'
        ]);

    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json([
        'success' => true,
        'message' => 'User berhasil dihapus'
    ]);
}
}
