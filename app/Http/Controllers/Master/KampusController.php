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
                <button data-id=""
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
