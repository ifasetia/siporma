<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Master\StatusProyek;
use Illuminate\Http\Request;
use App\Models\Master\Teknologi;
use App\Models\Master\Kampus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{

    public function dashboard()
    {

    $statusPublic = StatusProyek::where(
    'sp_nama_status',
    'Divalidasi (Public)'
    )->first();

    $projects = Project::with([
    'user.profile.kampus',
    'teknologis',
    'masterStatus'
    ])
    ->where('status_id', $statusPublic->sp_id)
    ->latest()
    ->limit(6)
    ->get();


    // =====================
    // STATISTIK REAL
    // =====================

    $totalIntern = User::where('role','intern')->count();

    $totalProject = Project::where('status_id',$statusPublic->sp_id)->count();

    $totalKampus = Kampus::count();

    $totalTeknologi = Teknologi::count();


    return view('pages.public.dashboard', compact(
    'projects',
    'totalIntern',
    'totalProject',
    'totalKampus',
    'totalTeknologi'
    ));

    }

public function projects(Request $request)
{
    $query = Project::with([
    'user.profile.kampus',
    'teknologis',
    'masterStatus'
    ])
    ->whereHas('masterStatus', function ($q) {
        $q->where('sp_nama_status', 'Divalidasi (Public)');
    })
    ->latest();

    // $query = Project::with([
    //     'user.profile.kampus',
    //     'teknologis',
    //     'masterStatus'
    // ])
    // ->whereHas('masterStatus', function ($q) {
    //     $q->where('sp_nama_status', 'Divalidasi (Public)');
    // });

    // SEARCH
    if ($request->search) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            // cari di judul project
            $q->where('title', 'ilike', "%{$search}%")

            // cari nama pembuat project
            ->orWhereHas('user.profile', function ($q) use ($search) {
                $q->where('pr_nama', 'ilike', "%{$search}%");
            })

            // cari nama kolaborator
            ->orWhereHas('collaborators.profile', function ($q) use ($search) {
                $q->where('pr_nama', 'ilike', "%{$search}%");
            })

            // cari nama kampus
            ->orWhereHas('user.profile.kampus', function ($q) use ($search) {
                $q->where('km_nama_kampus', 'ilike', "%{$search}%");
            });

        });

    }


    
    // FILTER TEKNOLOGI
    if ($request->teknologi) {

    $query->whereHas('teknologis', function ($q) use ($request) {

    $q->where('teknologi_id', $request->teknologi);

    });

    }


    // FILTER KAMPUS
    if ($request->kampus) {

    $query->whereHas('user.profile.kampus', function ($q) use ($request) {
    $q->where('km_id',$request->kampus);
    });

    }


    // SORT
    if ($request->sort == 'popular') {

    $query->latest();

    } else {

    $query->latest();

    }


        $projects = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {

        return view('pages.public.components.project-list', compact('projects'))->render();

        }
         // 🔥 TAMBAHKAN INI
        $teknologis = Teknologi::orderBy('tk_nama')->get();
        $kampus = Kampus::orderBy('km_nama_kampus')->get();

        return view('pages.public.project', compact(
        'projects',
        'teknologis',
        'kampus'
        ));

    }

public function detailProject($id)
{

    $project = Project::with([
        'user.profile.kampus',
        'teknologis',
        'photos',
        'links',
        'collaborators'
    ])->findOrFail($id);

    return view('pages.public.project-detail', compact('project'));

}

public function analytics()
{

$statusPublic = StatusProyek::where(
'sp_nama_status',
'Divalidasi (Public)'
)->first();


/* ======================
   CARD STATISTICS
====================== */

$totalIntern = User::where('role','intern')->count();

$totalProject = Project::where('status_id',$statusPublic->sp_id)->count();

$totalKampus = Kampus::count();

$totalTeknologi = Teknologi::count();


/* ======================
   INTERN PER KAMPUS
====================== */

$internPerKampus = DB::table('profiles')
->join('ms_kampus','profiles.pr_km_id','=','ms_kampus.km_id')
->select('ms_kampus.km_nama_kampus',DB::raw('count(*) as total'))
->groupBy('ms_kampus.km_nama_kampus')
->get();


/* ======================
   INTERN PER JURUSAN
====================== */

$internPerJurusan = DB::table('profiles')
->join('ms_jurusan','profiles.pr_js_id','=','ms_jurusan.js_id')
->select('ms_jurusan.js_nama',DB::raw('count(*) as total'))
->groupBy('ms_jurusan.js_nama')
->get();


/* ======================
   TEKNOLOGI PROJECT
====================== */

$techProject = DB::table('project_teknologi')
->join('ms_teknologi','project_teknologi.teknologi_id','=','ms_teknologi.tk_id')
->select('ms_teknologi.tk_nama',DB::raw('count(*) as total'))
->groupBy('ms_teknologi.tk_nama')
->get();


/* ======================
   KATEGORI TEKNOLOGI
====================== */

$techCategory = DB::table('project_teknologi')
->join('ms_teknologi','project_teknologi.teknologi_id','=','ms_teknologi.tk_id')
->select('ms_teknologi.tk_kategori',DB::raw('count(*) as total'))
->groupBy('ms_teknologi.tk_kategori')
->get();

$menunggu = Project::whereHas('masterStatus', function ($q) {
    $q->where('sp_nama_status', 'Menunggu Validasi');
})->count();

$revisi = Project::whereHas('masterStatus', function ($q) {
    $q->where('sp_nama_status', 'Revisi');
})->count();

$divalidasi = Project::whereHas('masterStatus', function ($q) {
    $q->where('sp_nama_status', 'Divalidasi (Public)');
})->count();


return view('pages.public.analytics',[
    'totalIntern'=>$totalIntern,
    'totalProject'=>$totalProject,
    'totalKampus'=>$totalKampus,
    'totalTeknologi'=>$totalTeknologi,
    'internPerKampus'=>$internPerKampus,
    'internPerJurusan'=>$internPerJurusan,
    'techProject'=>$techProject,
    'techCategory'=>$techCategory,
    // TAMBAHAN INI 🔥
    'menunggu'=>$menunggu,
    'revisi'=>$revisi,
    'divalidasi'=>$divalidasi
]);

}
public function landing()
{
    $statusPublic = StatusProyek::where(
        'sp_nama_status',
        'Divalidasi (Public)'
    )->first();

    $totalIntern = User::where('role','intern')->count();
    $totalProject = Project::where('status_id',$statusPublic->sp_id)->count();
    $totalKampus = Kampus::count();
    $totalTeknologi = Teknologi::count();

    $menunggu = Project::whereHas('masterStatus', function ($q) {
    $q->where('sp_nama_status', 'Menunggu Validasi');
    })->count();

    $revisi = Project::whereHas('masterStatus', function ($q) {
        $q->where('sp_nama_status', 'Revisi');
    })->count();

    $divalidasi = Project::whereHas('masterStatus', function ($q) {
        $q->where('sp_nama_status', 'Divalidasi (Public)');
    })->count();


    return view('welcome', compact(
        'totalIntern',
        'totalProject',
        'totalKampus',
        'totalTeknologi',
        'menunggu',
        'revisi',
        'divalidasi'
    ));
}

}
