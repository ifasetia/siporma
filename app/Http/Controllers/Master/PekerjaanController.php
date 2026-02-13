<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables; // Pastikan pakai Facades agar lebih stabil
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class PekerjaanController extends Controller
{

    public function index()
    {
        return view('pages.master.pekerjaan.index');
    }

    public function datatable(Request $request)
    {
        $query = Pekerjaan::query()->latest('created_at');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
                <div class="flex items-center justify-center gap-1.5">
                    <button type="button"
                        data-id="' . $row->pk_id_pekerjaan . '"
                        class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                        </svg>
                        Edit
                    </button>

                    <button type="button"
                        data-id="' . $row->pk_id_pekerjaan . '"
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

    public function create()
    {
        return view('pages.master.pekerjaan.add');
    }

    public function store(Request $request)
    {
        // Wajib request AJAX/JSON untuk sistem Modal
        if (!$request->expectsJson()) {
            abort(400, 'Invalid request type');
        }

        try {
            $data = $request->validate([
                'pk_kode_tipe_pekerjaan' => 'required|string|max:50',
                'pk_nama_pekerjaan' => 'required|string|max:255',
                'pk_deskripsi_pekerjaan' => 'required|string',
                'pk_level_pekerjaan' => 'required|string',
                'pk_estimasi_durasi_hari' => 'required|integer|min:1',
                'pk_minimal_skill' => 'required|string',
            ], [
                'pk_kode_tipe_pekerjaan.required' => 'Kode pekerjaan wajib diisi',
                'pk_nama_pekerjaan.required' => 'Nama pekerjaan wajib diisi',
                'pk_deskripsi_pekerjaan.required' => 'Deskripsi wajib diisi',
                'pk_level_pekerjaan.required' => 'Level pekerjaan wajib dipilih',
                'pk_estimasi_durasi_hari.required' => 'Estimasi hari wajib diisi',
                'pk_estimasi_durasi_hari.integer' => 'Estimasi harus angka',
                'pk_minimal_skill.required' => 'Minimal skill wajib diisi',
            ]);

            DB::beginTransaction();
            $pekerjaan = Pekerjaan::create($data);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pekerjaan berhasil ditambahkan',
                'data' => $pekerjaan
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $pekerjaan
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'pk_kode_tipe_pekerjaan' => 'required',
                'pk_nama_pekerjaan' => 'required',
                'pk_deskripsi_pekerjaan' => 'required',
                'pk_level_pekerjaan' => 'required',
                'pk_estimasi_durasi_hari' => 'required|numeric',
                'pk_minimal_skill' => 'required',
            ]);

            DB::beginTransaction();
            $pekerjaan = Pekerjaan::findOrFail($id);
            $pekerjaan->update($data);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pekerjaan berhasil diupdate'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ini untuk menangkap error validasi dan mengirimnya ke JavaScript
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal update: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $pekerjaan = Pekerjaan::findOrFail($id);
            $pekerjaan->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pekerjaan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}
