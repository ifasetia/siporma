<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Master\StatusProyek;
use Illuminate\Http\Request;
use App\Models\Master\Teknologi;
use App\Models\Master\Kampus;

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
        return view('pages.public.dashboard', compact('projects'));
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
    });

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
    $q->where('id',$request->teknologi);
    });

    }


    // FILTER KAMPUS
    if ($request->kampus) {

    $query->whereHas('user.profile.kampus', function ($q) use ($request) {
    $q->where('id',$request->kampus);
    });

    }


    // SORT
    if ($request->sort == 'popular') {

    $query->orderBy('views','desc');

    } else {

    $query->latest();

    }


        $projects = $query->latest()->paginate(9);
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

}
