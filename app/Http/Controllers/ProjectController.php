<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectFile;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function index()
    {
        return view('pages.projects.index');
    }

    // ======================
    // DATATABLE
    // ======================
    public function datatable(Request $request)
    {
        $query = Project::where('created_by', auth()->id())
            ->latest();

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('status', function ($row) {
                if ($row->status === 'menunggu_validasi') {
                    return '<span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Menunggu</span>';
                }

                return '<span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">Disetujui</span>';
            })

            ->addColumn('aksi', function ($row) {
                return '
                <div class="flex items-center justify-center gap-1.5">

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

            ->rawColumns(['aksi','status'])
            ->make(true);
    }

    // ======================
    // STORE
    // ======================
    public function store(Request $request)
    {
        if (!$request->expectsJson()) abort(400);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'technologies' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $project = Project::create([
                'id' => Str::uuid(),
                'title' => $data['title'],
                'description' => $data['description'],
                'technologies' => $data['technologies'],
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            // creator otomatis jadi member
            ProjectMember::create([
                'id' => Str::uuid(),
                'project_id' => $project->id,
                'user_id' => auth()->id()
            ]);

            // upload file
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {

                    $path = $file->store('projects', 'public');

                    ProjectFile::create([
                        'id' => Str::uuid(),
                        'project_id' => $project->id,
                        'file_path' => $path
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Project berhasil ditambahkan'
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        $data = Project::findOrFail($id);

        return response()->json([
            'success'=>true,
            'data'=>$data
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
}