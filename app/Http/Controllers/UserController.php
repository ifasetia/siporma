<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function index()
    {
        $user = User::latest()->paginate(10);
        //dd($user->toArray());
        return view('pages.user.index', compact('user'));
    }

    public function datatable(Request $request)
    {

        $query = User::query()->latest('created_at');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                    <div class="flex items-center justify-center gap-1.5">

                        <!-- BUTTON EDIT -->
                        <button
                            type="button"
                            data-id="' . $row->id . '"
                            class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                            </svg>

                            Edit
                        </button>

                        <!-- BUTTON DELETE -->
                        <button
                            type="button"
                            data-id="' . $row->id . '"
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
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required'
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


}

