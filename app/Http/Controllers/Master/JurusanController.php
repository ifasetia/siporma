<?php

namespace App\Http\Controllers\Master;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Jurusan; // Alamat baru model kamu sengkkuu!
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;


class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::latest()->paginate(10);
        // dd($jurusan);
        return view('pages.master.jurusan.index', compact('jurusan'));
    }

    public function datatable(Request $request)
    {
        $query = Jurusan::query()->latest('created_at');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                // GANTI js_id MENJADI id
                return '
                    <div class="flex items-center justify-center gap-1.5">
                        <button
                            type="button"
                            data-id="' . $row->js_id . '"
                            class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                            </svg>
                            Edit
                        </button>

                        <button
                            type="button"
                            data-id="' . $row->js_id . '"
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

    // FORM TAMBAH
    public function create()
    {
        return view('jurusan.create');
    }



    // SIMPAN DATA
    public function store(Request $request) // Pakai Request biasa
{
    if (!$request->expectsJson()) {
        abort(400, 'Invalid request type');
    }

    // Ganti $request->validated() menjadi $request->validate()
    $data = $request->validate([
        'js_nama' => 'required|string|max:255',
        'js_kode' => 'required|string|unique:ms_jurusan,js_kode',
    ], [
        'js_nama.required' => 'Nama jurusan tidak boleh kosong!',
        'js_kode.required' => 'Kode jurusan tidak boleh kosong!',
        'js_kode.unique' => 'Kode jurusan ini sudah terdaftar!',
    ]);

    $jurusan = new Jurusan();
    $jurusan->js_nama = $data['js_nama'];
    $jurusan->js_kode = $data['js_kode'];
    $jurusan->save();

    return response()->json([
        'success' => true,
        'message' => 'Data jurusan berhasil ditambahkan',
        'data' => $jurusan
    ], 201);
}

    // FORM EDIT
    public function edit($id)
    {
        $data = Jurusan::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // UPDATE DATA
    public function update(Request $request, $id) // Gunakan Request biasa agar lebih fleksibel
    {
        // 1. Wajib request ajax/json
        if (!$request->expectsJson()) {
            abort(400, 'Invalid request type');
        }

        // 2. Validasi field yang BENAR (sesuaikan dengan input name di blade)
        $data = $request->validate([
            'js_nama'   => 'required|string|max:255',
            'js_kode'   => 'required|string|max:50',
        ], [
            'js_nama.required' => 'Nama jurusan wajib diisi',
            'js_kode.required'   => 'Kode jurusan wajib diisi',
            // tambahkan pesan custom lainnya jika perlu
        ]);

        // 3. Cari data jurusan
        $jurusan = Jurusan::findOrFail($id);

        // 4. Update field (pastikan key $data sesuai dengan key di array validasi di atas)
        $jurusan->js_nama = $data['js_nama'];
        $jurusan->js_kode= $data['js_kode'];
        $jurusan->save();

        // 5. Response ajax
        return response()->json([
            'success' => true,
            'message' => 'Data jurusan berhasil diupdate',
            'data' => $jurusan
        ], 200);
    }


    // HAPUS DATA
    public function destroy($id)
    {
        $data = Jurusan::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
