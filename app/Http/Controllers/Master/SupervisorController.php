<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SupervisorController extends Controller
{
    public function index()
    {
        // Mengambil data untuk fallback jika datatable gagal (opsional)
        $supervisors = Supervisor::latest()->paginate(10);
        return view('pages.master.supervisor.index', compact('supervisors'));
    }

    public function datatable(Request $request)
    {
        $query = Supervisor::query()->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                    <div class="flex items-center justify-center gap-2">
                        <button type="button" data-id="' . $row->sp_id . '"
                            class="btn-edit inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button type="button" data-id="' . $row->sp_id . '"
                            class="btn-delete inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sp_nip'     => 'required|unique:supervisors,sp_nip',
            'sp_nama'    => 'required',
            'sp_jabatan' => 'required',
            'sp_divisi'  => 'required',
            'sp_email'   => 'required|email|unique:supervisors,sp_email',
            'sp_telepon' => 'required',
        ]);

        try {
            Supervisor::create([
                'sp_id'      => Str::uuid(),
                'sp_nip'     => $request->sp_nip,
                'sp_nama'    => $request->sp_nama,
                'sp_jabatan' => $request->sp_jabatan,
                'sp_divisi'  => $request->sp_divisi,
                'sp_email'   => $request->sp_email,
                'sp_telepon' => $request->sp_telepon,
            ]);

            return response()->json(['success' => true, 'message' => 'Data Supervisor berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        return response()->json(['data' => $supervisor]);
    }

    public function update(Request $request, $id)
    {
        // 1. Cari data berdasarkan sp_id
        $supervisor = Supervisor::findOrFail($id);

        // 2. Validasi: Tambahkan $id dan 'sp_id' agar NIP sendiri tidak dianggap duplikat
        $validated = $request->validate([
        'sp_nip'     => 'required|unique:supervisors,sp_nip,' . $id . ',sp_id',
        'sp_nama'    => 'required',
        'sp_jabatan' => 'required',
        'sp_divisi'  => 'required',
        'sp_email'   => 'required|email|unique:supervisors,sp_email,' . $id . ',sp_id',
        'sp_telepon' => 'required',
        ]);

        // 3. Update semua data yang dikirim dari form
        Supervisor::where('sp_id', $id)->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Supervisor berhasil diperbarui!'
        ]);
    }

    public function destroy($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $supervisor->delete();

        return response()->json(['success' => true, 'message' => 'Data Supervisor berhasil dihapus!']);
    }
}
