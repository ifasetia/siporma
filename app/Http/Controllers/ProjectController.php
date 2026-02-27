<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectFile;
use App\Models\ProjectLink;
use App\Models\ProjectPhoto;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class ProjectController extends Controller
{

   public function index()
{
    $interns = User::where('role','intern')
    ->where('id','!=', auth()->id())
    ->get();

    return view('pages.projects.index', compact('interns'));
}

    // ======================
    // DATATABLE
    // ======================
    public function datatable(Request $request)
    {
        // PENTING: Tambahkan with('masterStatus') agar data master ikut terpanggil
        $query = Project::with(['masterStatus','teknologis'])
    ->where(function($q){
        $q->where('created_by', auth()->id())
          ->orWhereHas('collaborators', function($q2){
              $q2->where('users.id', auth()->id());
          });
    })
    ->latest();


        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('technologies', function ($row) {

    if ($row->teknologis->count()) {

        return $row->teknologis
            ->pluck('tk_nama')
            ->map(function($nama){
                return '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full mr-1">'.$nama.'</span>';
            })
            ->implode(' ');

    }

    return '<span class="text-gray-400">-</span>';
})
            ->addColumn('status', function ($row) {
                // Sekarang kita tarik nama dan warna langsung dari tabel master_status_proyek!
                if ($row->masterStatus) {
                    return '<span class="px-3 py-1 text-xs rounded-full ' . $row->masterStatus->sp_warna . '">' . $row->masterStatus->sp_nama_status . '</span>';
                }

                return '<span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">Tidak ada status</span>';
            })
            ->addColumn('aksi', function ($row) {
    return '
    <div class="flex items-center justify-center gap-1.5">

        <button
            type="button"
            data-id="'.$row->id.'"
            class="btn-detail inline-flex items-center gap-1.5 rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 hover:bg-gray-200">
            Detail
        </button>

        <button
            type="button"
            data-id="'.$row->id.'"
            class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100">
            Edit
        </button>

        <button
            type="button"
            data-id="'.$row->id.'"
            class="btn-delete inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100">
            Hapus
        </button>

    </div>';
})
            ->rawColumns(['aksi','status','technologies'])
            ->make(true);
    }


    // ======================
    // STORE
    // ======================
   public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required',
        'teknologis' => 'required|array',
        'teknologis.*' => 'exists:ms_teknologi,tk_id',
        'links.*.url' => 'nullable|url',
        'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'files.*' => 'nullable|file|max:5120',
    ]);

    DB::beginTransaction();

    try {

        $statusMenunggu = DB::table('master_status_proyek')
            ->where('sp_nama_status', 'Menunggu Validasi')
            ->first();

        $project = Project::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status_id' => $statusMenunggu ? $statusMenunggu->sp_id : null,
            'created_by' => auth()->id(),
        ]);

        // 🔥 ATTACH TEKNOLOGI
        $project->teknologis()->attach($data['teknologis']);

        // FILE
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('project-files','public');
                ProjectFile::create([
                    'id' => Str::uuid(),
                    'project_id' => $project->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        // LINKS
        if ($request->links) {
            foreach ($request->links as $link) {
                if (!empty($link['url'])) {
                    ProjectLink::create([
                        'id' => Str::uuid(),
                        'project_id' => $project->id,
                        'label' => $link['label'] ?? 'Link',
                        'url' => $link['url'],
                    ]);
                }
            }
        }

        // PHOTOS
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('project-photos', 'public');
                ProjectPhoto::create([
                    'id' => Str::uuid(),
                    'project_id' => $project->id,
                    'photo' => $path,
                ]);
            }
        }

        // MEMBERS
        $members = $request->members ?? [];

        // Tambahkan creator otomatis
        $members[] = auth()->id();

        // Hilangkan duplikat
        $members = array_unique($members);

        // Sync ke pivot project_members
        $project->members()->sync($members);
                
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Project berhasil disimpan'
        ]);

    } catch (\Throwable $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        $project = Project::with([
            'links',
            'files',
            'photos',
            'members',
            'teknologis' // 🔥 WAJIB TAMBAH INI // 🔥 TAMBAH INI
        ])->findOrFail($id);

        return response()->json([
            'data' => $project
        ]);
    }

    // ======================
    // UPDATE
    // ======================
    public function update(Request $request, $id)
    {
        if (!$request->expectsJson()) abort(400);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'teknologis' => 'required|array',
            'teknologis.*' => 'exists:ms_teknologi,tk_id',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
            'links' => 'nullable|array',
            'files.*' => 'nullable|file',
            'photos.*' => 'nullable|image'
        ]);

        $project = Project::findOrFail($id);

        // ========================
        // UPDATE DATA UTAMA
        // ========================
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // ========================
        // SYNC RELASI
        // ========================
        $project->teknologis()->sync($request->teknologis);
        $members = $request->members ?? [];

if (!is_array($members)) {
    $members = [$members];
}

$project->collaborators()->sync($members);

        // ========================
        // UPDATE LINKS (RESET + INSERT ULANG)
        // ========================
        $project->links()->delete();

        if ($request->links) {
            foreach ($request->links as $link) {
                if (!empty($link['label']) && !empty($link['url'])) {
                    $project->links()->create([
                        'label' => $link['label'],
                        'url' => $link['url'],
                    ]);
                }
            }
        }
        try {

    $members = $request->members ?? [];

    if (!is_array($members)) {
        $members = [$members];
    }

    $project->collaborators()->sync($members);
    $project->update($data);
    $project->teknologis()->sync($data['teknologis']);

    return response()->json([
        'success'=>true,
        'message'=>'Project berhasil diupdate'
    ]);

} catch (\Exception $e) {

    return response()->json([
        'error'=>$e->getMessage()
    ],500);

}

        // ========================
        // TAMBAH FILE BARU
        // ========================
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('project-files', 'public');

                $project->files()->create([
                    'file_path' => $path
                ]);
            }
        }

        // ========================
        // TAMBAH FOTO BARU
        // ========================
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('project-photos', 'public');

                $project->photos()->create([
                    'photo' => $path
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Project berhasil diupdate'
        ]);
    }

    // ======================
    // DELETE
    // ======================
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Project berhasil dihapus'
        ]);
    }


    // ======================
    // DETAIL
    // ======================
    public function detail($id)
    {
        $project = Project::with([
            'links',
            'photos',
            'files',
            'members',
            'masterStatus', // ⬅️ TAMBAH INI
            'teknologis'
        ])->findOrFail($id);

        return response()->json([
            'success'=>true,
            'data'=>$project
        ]);
    }
}
