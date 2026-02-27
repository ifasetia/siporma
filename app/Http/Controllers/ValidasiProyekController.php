<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Master\StatusProyek; // Pastikan namespace model status proyekmu benar
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ValidasiProyekController extends Controller
{
    // Menampilkan halaman tabel Validasi
    public function index()
    {
        $statuses = \App\Models\Master\StatusProyek::all();
        return view('pages.validasi_proyek.index', compact('statuses'));
    }

    // Mengambil data untuk DataTables
    public function datatable(Request $request)
    {
        // Admin melihat SEMUA proyek dari semua intern, kita tarik relasi pembuat dan statusnya
        $query = Project::with(['masterStatus', 'members']) // asumsikan ada relasi ke user
            ->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('intern_name', function ($row) {
                // Mengambil nama pembuat proyek (opsional, sesuaikan dengan struktur relasimu)
                // Sementara kita asumsikan pakai user id dari created_by
                $user = DB::table('users')->where('id', $row->created_by)->first();
                return $user ? $user->name : 'Unknown';
            })
            ->addColumn('status', function ($row) {
                if ($row->masterStatus) {
                    return '<span class="px-3 py-1 text-xs rounded-full ' . $row->masterStatus->sp_warna . '">' . $row->masterStatus->sp_nama_status . '</span>';
                }
                return '<span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Belum ada status</span>';
            })
            
            ->addColumn('aksi', function ($row) {

    return '
    <div class="flex gap-2 justify-center">

        <button
            type="button"
            data-id="'.$row->id.'"
            class="btn-review px-3 py-1 text-xs rounded bg-indigo-100 text-indigo-700">
            Review
        </button>

        <button
            type="button"
            data-id="'.$row->id.'"
            class="btn-validasi px-3 py-1 text-xs rounded bg-blue-100 text-blue-700">
            Validasi
        </button>

    </div>';
})

            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    // Fungsi untuk memproses perubahan status (Misal: dari Menunggu jadi Disetujui/Revisi)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required'
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'status_id' => $request->status_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status proyek berhasil diperbarui!'
        ]);
    }

    public function validasi($id)
{
    $project = Project::with([
        'masterStatus',
        'members',
        'links',
        'photos',
        'files',
        'teknologis'
    ])->findOrFail($id);

    $statuses = StatusProyek::all();

    return view('pages.validasi_proyek.validasi', compact('project','statuses'));
}
    
}
