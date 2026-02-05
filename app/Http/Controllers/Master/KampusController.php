<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
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
        $query = Kampus::query();

        // dd($query->get());

        $query = Kampus::query();

        return DataTables::of($query)
            ->addIndexColumn() // ← DT_RowIndex
            ->addColumn('aksi', function ($row) {
                return '
                <div class="flex justify-center gap-2">
                    <a href=""
                        class="px-3 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600">
                        Edit
                    </a>
                    <button data-id="'.$row->id.'"
                        class="btn-delete px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">
                        Hapus
                    </button>
                </div>
            ';
            })
            ->rawColumns(['aksi']) // 🔥 WAJIB
            ->make(true);
    }

    // FORM TAMBAH
    public function create()
    {
        return view('kampus.create');
    }



    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'nama_kampus' => 'required|string|max:255',
            'alamat'      => 'nullable|string',
            'kota'        => 'nullable|string|max:100',
            'email'       => 'nullable|email',
            'telepon'     => 'nullable|string|max:20',
        ]);

        Kampus::create($request->all());

        return redirect()
            ->route('kampus.index')
            ->with('success', 'Data kampus berhasil ditambahkan');
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
    public function destroy(Kampus $kampus)
    {
        $kampus->delete();

        return redirect()
            ->route('kampus.index')
            ->with('success', 'Data kampus berhasil dihapus');
    }
}
