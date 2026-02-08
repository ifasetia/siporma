<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
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
                $editBtn = '<a href="' . route('pekerjaan.edit', $row->pk_id_pekerjaan) . '"
                                class="inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                                </svg>
                                Edit
                            </a>';

                // CSRF token
                $csrf = csrf_token();

                $deleteBtn = '<form action="' . route('pekerjaan.delete', $row->pk_id_pekerjaan) . '" method="POST" class="inline-block" onsubmit="return confirm(\'Yakin hapus data ini?\')">
                    <input type="hidden" name="_token" value="' . $csrf . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 7h12M9 7V5h6v2m-7 0l1 12h8l1-12"/>
                        </svg>
                        Hapus
                    </button>
                </form>';

                return '<div class="flex items-center justify-center gap-1.5">' . $editBtn . $deleteBtn . '</div>';
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
            Pekerjaan::create($data);


            // $pekerjaan = new Pekerjaan();

            // $pekerjaan->pk_kode_tipe_pekerjaan = $request->pk_kode_tipe_pekerjaan;
            // $pekerjaan->pk_nama_pekerjaan = $request->pk_nama_pekerjaan;
            // $pekerjaan->pk_deskripsi_pekerjaan = $request->pk_deskripsi_pekerjaan;
            // $pekerjaan->pk_level_pekerjaan = $request->pk_level_pekerjaan;
            // $pekerjaan->pk_estimasi_durasi_hari = $request->pk_estimasi_durasi_hari;
            // $pekerjaan->pk_minimal_skill = $request->pk_minimal_skill;

            // $pekerjaan->save();

            DB::commit();

            return redirect()
                ->route('pekerjaan.index')
                ->with('success', 'Data pekerjaan berhasil ditambahkan');
        } catch (ValidationException $e) {

            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Periksa kembali input anda');
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        return view('pages.master.pekerjaan.edit', compact('pekerjaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pk_kode_tipe_pekerjaan' => 'required',
            'pk_nama_pekerjaan' => 'required',
            'pk_deskripsi_pekerjaan' => 'required',
            'pk_level_pekerjaan' => 'required',
            'pk_estimasi_durasi_hari' => 'required|numeric',
            'pk_minimal_skill' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $pekerjaan = Pekerjaan::findOrFail($id);

            $pekerjaan->pk_kode_tipe_pekerjaan = $request->pk_kode_tipe_pekerjaan;
            $pekerjaan->pk_nama_pekerjaan = $request->pk_nama_pekerjaan;
            $pekerjaan->pk_deskripsi_pekerjaan = $request->pk_deskripsi_pekerjaan;
            $pekerjaan->pk_level_pekerjaan = $request->pk_level_pekerjaan;
            $pekerjaan->pk_estimasi_durasi_hari = $request->pk_estimasi_durasi_hari;
            $pekerjaan->pk_minimal_skill = $request->pk_minimal_skill;

            $pekerjaan->save();

            DB::commit();

            return redirect()->route('pekerjaan.index')
                ->with('success', 'Data pekerjaan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // pakai model Eloquent
            $pekerjaan = Pekerjaan::findOrFail($id);
            $pekerjaan->delete();

            DB::commit();

            return redirect()->route('pekerjaan.index')
                ->with('success', 'Data pekerjaan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }
}
