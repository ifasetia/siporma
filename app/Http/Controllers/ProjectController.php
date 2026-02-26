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
    $interns = User::where('role', 'intern')->get();

    return view('pages.projects.index', compact('interns'));
}

    // ======================
    // DATATABLE
    // ======================
    public function datatable(Request $request)
    {
        // PENTING: Tambahkan with('masterStatus') agar data master ikut terpanggil
        $query = Project::with('masterStatus')->where('created_by', auth()->id())->latest();

        return DataTables::of($query)
            ->addIndexColumn()
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
                    <button type="button" data-id="'.$row->id.'" class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100">
                        Edit
                    </button>
                    <button type="button" data-id="'.$row->id.'" class="btn-delete inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100">
                        Hapus
                    </button>
                </div>';
            })
            ->rawColumns(['aksi','status'])
            ->make(true);
    }


    // ======================
    // STORE
    // ======================
   public function store(Request $request)
{
    $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required',
    'technologies' => 'required',

    'links.*.url' => 'nullable|url',
    'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    'files.*' => 'nullable|file|max:5120', // ⬅️ TAMBAH INI
]);


    DB::beginTransaction();

    try {
            // Cari ID status "Menunggu Validasi" dari master data otomatis
            $statusMenunggu = DB::table('master_status_proyek')->where('sp_nama_status', 'Menunggu Validasi')->first();

            $project = Project::create([
                'id' => Str::uuid(),
                'title' => $data['title'],
                'description' => $data['description'],
                'technologies' => $data['technologies'],
                'status_id' => $statusMenunggu ? $statusMenunggu->sp_id : null, // Masukkan UUID-nya
                'created_by' => auth()->id(),
            ]);

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

        // 2️⃣ SAVE LINKS (bio style)
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

        // 3️⃣ SAVE PHOTOS
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

        // 4️⃣ SAVE MEMBERS
        $members = $request->members ?? [];

        // creator auto jadi member
        $members[] = auth()->id();

        foreach (array_unique($members) as $userId) {

            ProjectMember::create([
                'id' => Str::uuid(),
                'project_id' => $project->id,
                'user_id' => $userId,
            ]);
        }

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
            'photos'
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
            'title'=>'required',
            'description'=>'required',
            'technologies'=>'required'
        ]);

        $project = Project::findOrFail($id);

        $project->update($data);

        return response()->json([
            'success'=>true,
            'message'=>'Project berhasil diupdate'
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
        $project = Project::with(['links','photos','files','members.user'])->findOrFail($id);

        return response()->json([
            'success'=>true,
            'data'=>$project
        ]);
    }
    }
