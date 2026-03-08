<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Master\Kampus;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {

        // CARD STATISTICS
        $totalIntern = User::where('role','intern')->count();
        $totalAdmin = User::whereIn('role',['admin','super_admin'])->count();
        $totalUsers = User::count();
        $totalKampus = Kampus::count();


        // INTERN PER KAMPUS
        $internPerKampus = DB::table('profiles')
            ->join('ms_kampus', 'profiles.pr_km_id', '=', 'ms_kampus.km_id')
            ->select('ms_kampus.km_nama_kampus', DB::raw('count(*) as total'))
            ->groupBy('ms_kampus.km_nama_kampus')
            ->get();

        // INTERN PER JURUSAN
        $internPerJurusan = DB::table('profiles')
            ->join('ms_jurusan', 'profiles.pr_js_id', '=', 'ms_jurusan.js_id')
            ->select('ms_jurusan.js_nama', DB::raw('count(*) as total'))
            ->groupBy('ms_jurusan.js_nama')
            ->get();

        // TEKNOLOGI PROJECT
        $techProject = DB::table('project_teknologi')
            ->join('ms_teknologi', 'project_teknologi.teknologi_id', '=', 'ms_teknologi.tk_id')
            ->select('ms_teknologi.tk_nama', DB::raw('count(*) as total'))
            ->groupBy('ms_teknologi.tk_nama')
            ->get();

        $techCategory = DB::table('project_teknologi')
            ->join('ms_teknologi','project_teknologi.teknologi_id','=','ms_teknologi.tk_id')
            ->select('ms_teknologi.tk_kategori', DB::raw('count(*) as total'))
            ->groupBy('ms_teknologi.tk_kategori')
            ->get();


        return view('pages.analytics.index',[
            'totalIntern'=>$totalIntern,
            'totalAdmin'=>$totalAdmin,
            'totalUsers'=>$totalUsers,
            'totalKampus'=>$totalKampus,
            'internPerKampus'=>$internPerKampus,
            'internPerJurusan'=>$internPerJurusan,
            'techProject'=>$techProject,
            'techCategory'=>$techCategory
        ]);
    }
}
