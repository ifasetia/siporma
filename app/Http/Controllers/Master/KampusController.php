<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKampusRequest;
use Illuminate\Http\Request;
use App\Models\Master\Kampus;
use Yajra\DataTables\Facades\DataTables;

class KampusController extends Controller
{
    public function index()
    {
        $kampus = Kampus::latest()->paginate(10);
        // dd($kampus);
        return view('pages.master.kampus.index', compact('kampus'));
    }

    public function datatable(Request $request)
    {

        $query = Kampus::query()->latest('created_at');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '
            <div class="flex items-center justify-center gap-1.5">
                <a href=""
                    class="inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                    </svg>
                    Edit
                </a>
                <button data-id="' . $row->km_id . '"
                    class="btn-delete inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
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

    // FORM TAMBAH
    public function create()
    {
        return view('kampus.create');
    }



    // SIMPAN DATA
    public function store(StoreKampusRequest $request)
    {
        // dd($request->all());
        if (!$request->expectsJson()) {
            abort(400, 'Invalid request type');
        }
        // 1. ambil data valid dari input form
        $data = $request->validated();

        // 2. simpan ke database sesuai field model & migration
        // $kampus = Kampus::create($data);
        $kampus = new Kampus();


        $kampus->km_nama_kampus = $data['km_nama_kampus'];
        $kampus->km_kode_kampus = $data['km_kode_kampus'];
        $kampus->km_email = $data['km_email_kampus'];
        $kampus->km_alamat = $data['km_alamat_kampus'];
        $kampus->km_telepon = $data['km_telepon'];
        $kampus->save();


        // 3. kirim response ke frontend ajax
        return response()->json([
            'success' => true,
            'message' => 'Data kampus berhasil ditambahkan',
            'data' => $kampus
        ], 201);
    }

    // FORM EDIT
    public function edit(Kampus $kampus)
    {
        return view('kampus.edit', compact('kampus'));
    }

    // UPDATE DATA
    public function update(Request $request, Kampus $kampus)
    {
        $request->validate([
            'nama_kampus' => 'required|string|max:255',
            'alamat'      => 'nullable|string',
            'kota'        => 'nullable|string|max:100',
            'email'       => 'nullable|email',
            'telepon'     => 'nullable|string|max:20',
        ]);

        $kampus->update($request->all());

        return redirect()
            ->route('kampus.index')
            ->with('success', 'Data kampus berhasil diperbarui');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $data = Kampus::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
