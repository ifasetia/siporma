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

            // ===== STATUS COLUMN
            ->addColumn('status', function($row){

                $status = $row->sp_status ?? 'Nonaktif';

                if($status == 'Aktif'){
                    return '
                    <span
                        data-id="'.$row->sp_id.'"
                        data-status="Aktif"
                        class="toggle-status cursor-pointer inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Aktif
                    </span>';
                }

                return '
                <span
                    data-id="'.$row->sp_id.'"
                    data-status="Nonaktif"
                    class="toggle-status cursor-pointer inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                    Nonaktif
                </span>';
            })

            // ===== AKSI COLUMN
            ->addColumn('aksi', function ($row) {
                return '
                    <div class="flex items-center justify-center gap-2">
                        <button type="button" data-id="' . $row->sp_id . '"
                            class="btn-edit inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition">
                            ✏️
                        </button>
                        <button type="button" data-id="' . $row->sp_id . '"
                            class="btn-delete inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition">
                            🗑
                        </button>
                    </div>';
            })

            ->rawColumns(['aksi','status'])
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

    public function toggleStatus($id)
    {
        $supervisor = Supervisor::findOrFail($id);

        $supervisor->update([
            'sp_status' => $supervisor->sp_status == 'Aktif'
                ? 'Nonaktif'
                : 'Aktif'
        ]);

        return response()->json(['success'=>true]);
    }

    public function destroy($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $supervisor->delete();

        return response()->json(['success' => true, 'message' => 'Data Supervisor berhasil dihapus!']);
    }
}
