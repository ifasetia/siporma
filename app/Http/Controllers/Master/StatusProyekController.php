<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\StatusProyek; // Menggunakan model StatusProyek
use Yajra\DataTables\Facades\DataTables;

class StatusProyekController extends Controller
{
    // TAMPILAN HALAMAN UTAMA
    public function index()
    {
        // Pastikan struktur folder view-mu seperti ini nanti:
        return view('pages.master.status_proyek.index');
    }

    // AMBIL DATA UNTUK DATATABLES
    public function datatable(Request $request)
    {
        $query = StatusProyek::query()->latest('created_at');

        return DataTables::of($query)
            ->addIndexColumn()
            // Menambahkan kolom warna agar bisa ditampilkan dengan badge Tailwind
            ->editColumn('sp_warna', function($row) {
                return '<span class="px-2 py-1 text-xs rounded-md ' . $row->sp_warna . '">' . $row->sp_warna . '</span>';
            })
            ->addColumn('aksi', function ($row) {
                // Pastikan menggunakan sp_id agar tidak error saat edit/hapus
                return '
                    <div class="flex items-center justify-center gap-1.5">
                        <button
                            type="button"
                            data-id="' . $row->sp_id . '"
                            class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                            </svg>
                            Edit
                        </button>

                        <button
                            type="button"
                            data-id="' . $row->sp_id . '"
                            class="btn-delete inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5h6v2m-7 0l1 12h8l1-12"/>
                            </svg>
                            Hapus
                        </button>
                    </div>';
            })
            ->rawColumns(['sp_warna', 'aksi']) // Agar tag HTML di kolom warna & aksi dirender
            ->make(true);
    }

    // SIMPAN DATA BARU (ADD)
    public function store(Request $request)
    {
        if (!$request->expectsJson()) {
            abort(400, 'Invalid request type');
        }

        $data = $request->validate([
            'sp_nama_status' => 'required|string|max:255',
            'sp_warna'       => 'nullable|string|max:255',
            'sp_keterangan'  => 'nullable|string',
        ], [
            'sp_nama_status.required' => 'Nama status proyek tidak boleh kosong!',
        ]);

        $status = new StatusProyek();
        $status->sp_nama_status = $data['sp_nama_status'];
        // Jika warna dikosongkan, beri nilai default abu-abu
        $status->sp_warna = $data['sp_warna'] ?? 'bg-gray-100 text-gray-700 border-gray-200';
        $status->sp_keterangan = $data['sp_keterangan'] ?? null;
        $status->save();

        return response()->json([
            'success' => true,
            'message' => 'Data status proyek berhasil ditambahkan',
            'data'    => $status
        ], 201);
    }

    // AMBIL DATA UNTUK FORM EDIT
    public function edit($id)
    {
        $data = StatusProyek::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    // SIMPAN PERUBAHAN (UPDATE)
    public function update(Request $request, $id)
    {
        if (!$request->expectsJson()) {
            abort(400, 'Invalid request type');
        }

        $data = $request->validate([
            'sp_nama_status' => 'required|string|max:255',
            'sp_warna'       => 'nullable|string|max:255',
            'sp_keterangan'  => 'nullable|string',
        ], [
            'sp_nama_status.required' => 'Nama status proyek wajib diisi',
        ]);

        $status = StatusProyek::findOrFail($id);
        $status->sp_nama_status = $data['sp_nama_status'];
        $status->sp_warna = $data['sp_warna'] ?? 'bg-gray-100 text-gray-700 border-gray-200';
        $status->sp_keterangan = $data['sp_keterangan'] ?? null;
        $status->save();

        return response()->json([
            'success' => true,
            'message' => 'Data status proyek berhasil diupdate',
            'data'    => $status
        ], 200);
    }

    // HAPUS DATA (DELETE)
    public function destroy($id)
    {
        $data = StatusProyek::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
