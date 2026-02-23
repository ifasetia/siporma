<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Teknologi;
use Yajra\DataTables\Facades\DataTables;

class TeknologiController extends Controller
{
    // TAMPILAN HALAMAN UTAMA
    public function index()
    {
        return view('pages.master.teknologi.index');
    }

    // AMBIL DATA UNTUK DATATABLES
    public function datatable(Request $request)
    {
        $query = Teknologi::query()->latest('created_at');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                // Pastikan menggunakan tk_id agar tidak error saat edit/hapus
                return '
                    <div class="flex items-center justify-center gap-1.5">
                        <button
                            type="button"
                            data-id="' . $row->tk_id . '"
                            class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                            </svg>
                            Edit
                        </button>

                        <button
                            type="button"
                            data-id="' . $row->tk_id . '"
                            class="btn-delete inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5h6v2m-7 0l1 12h8l1-12"/>
                            </svg>
                            Hapus
                        </button>
                    </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // SIMPAN DATA BARU (ADD)
    public function store(Request $request)
    {
        if (!$request->expectsJson()) {
            abort(400, 'Invalid request type');
        }

        $data = $request->validate([
            'tk_nama'     => 'required|string|max:255',
            'tk_kategori' => 'required|string|max:255',
        ], [
            'tk_nama.required'     => 'Nama teknologi tidak boleh kosong!',
            'tk_kategori.required' => 'Kategori teknologi tidak boleh kosong!',
        ]);

        $teknologi = new Teknologi();
        $teknologi->tk_nama = $data['tk_nama'];
        $teknologi->tk_kategori = $data['tk_kategori'];
        $teknologi->save();

        return response()->json([
            'success' => true,
            'message' => 'Data teknologi berhasil ditambahkan',
            'data'    => $teknologi
        ], 201);
    }

    // AMBIL DATA UNTUK FORM EDIT
    public function edit($id)
    {
        $data = Teknologi::findOrFail($id);

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
            'tk_nama'     => 'required|string|max:255',
            'tk_kategori' => 'required|string|max:255',
        ], [
            'tk_nama.required'     => 'Nama teknologi wajib diisi',
            'tk_kategori.required' => 'Kategori teknologi wajib diisi',
        ]);

        $teknologi = Teknologi::findOrFail($id);
        $teknologi->tk_nama = $data['tk_nama'];
        $teknologi->tk_kategori = $data['tk_kategori'];
        $teknologi->save();

        return response()->json([
            'success' => true,
            'message' => 'Data teknologi berhasil diupdate',
            'data'    => $teknologi
        ], 200);
    }

    // HAPUS DATA (DELETE)
    public function destroy($id)
    {
        $data = Teknologi::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
