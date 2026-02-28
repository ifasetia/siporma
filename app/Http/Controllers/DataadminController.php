<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\Master\Kampus;
use Carbon\Carbon;



class DataadminController extends Controller
{
    public function index()
    {
         $kampus = Kampus::orderBy('km_nama_kampus')->get();

        return view('pages.data-admin.index', compact('kampus'));
        

    }

    public function detail($id)
        {
            $data = User::with(['profile','profile.kampus'])->findOrFail($id);

            return response()->json([
                'success'=>true,
                'data'=>$data
            ]);
        }


    public function datatable(Request $request)
{
    $query = User::with(['profile'])
        ->where('role','admin')
        ->latest();


    return DataTables::of($query)
        ->addIndexColumn()

        ->addColumn('pr_nama', fn($row)=> $row->profile->pr_nama ?? '-')
        ->addColumn('email', fn($row)=> $row->email)
        ->addColumn('pr_no_hp', fn($row)=> $row->profile->pr_no_hp ?? '-')
        ->addColumn('pr_posisi', fn($row)=> $row->profile->pr_posisi ?? '-')
        //->addColumn('pr_nim', fn($row)=> $row->profile->pr_nim ?? '-')
        //->addColumn('pr_kampus', function ($row) { 
            //return $row->profile?->kampus?->km_nama_kampus ?? '-';
           // })
        //->addColumn('pr_jurusan', fn($row)=> $row->profile->pr_jurusan ?? '-')

        // ===== STATUS TOGGLE
        ->addColumn('status', function($row){

            $status = $row->profile->pr_status ?? 'Nonaktif';

            if($status == 'Aktif'){
                return '
                <span
                    data-id="'.$row->id.'"
                    data-name="'.$row->name.'"
                    data-status="Aktif"
                    class="toggle-status cursor-pointer inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                    Aktif
                </span>';
            }

            return '
            <span
                data-id="'.$row->id.'"
                data-name="'.$row->name.'"
                data-status="Nonaktif"
                class="toggle-status cursor-pointer inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                Nonaktif
            </span>';
        })


        // ===== DETAIL BUTTON (STYLE KAMPUS)
        ->addColumn('detail', function ($row) {
            return '
                <button
                    type="button"
                    data-id="'.$row->id.'"
                    class="btn-detail inline-flex items-center gap-1.5 rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-600 hover:bg-indigo-100 transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    Detail
                </button>';
        })

        // ===== AKSI (EDIT + DELETE PERSIS KAMPUS)
        ->addColumn('aksi', function ($row) {
            return '
                <div class="flex items-center justify-center gap-1.5">

                    <!-- EDIT -->
                    <button
                        type="button"
                        data-id="'.$row->id.'"
                        class="btn-edit inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5L16.862 3.487z"/>
                        </svg>

                        Edit
                    </button>

                    <!-- DELETE -->
                    <button
                        type="button"
                        data-id="'.$row->id.'"
                        class="btn-delete inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 7h12M9 7V5h6v2m-7 0l1 12h8l1-12"/>
                        </svg>

                        Hapus
                    </button>

                </div>';
        })
        ->rawColumns(['aksi','detail','status'])
        ->make(true);
}

    public function store(Request $request)
    {
        try {

            $data = $request->validate([

                'name' => 'required',
                'email' => 'nullable|email',

                'pr_no_hp' => 'required',
                'pr_alamat' => 'required',
                'pr_jenis_kelamin' => 'required',
                'pr_tanggal_lahir' => 'required',
                'pr_status' => 'required',

                'pr_posisi' => 'required',

            ], [

                'name.required' => 'Nama wajib diisi',
                'pr_no_hp.required' => 'No HP wajib diisi',
                'pr_alamat.required' => 'Alamat wajib diisi',
                'pr_jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
                'pr_tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
                'pr_status.required' => 'Status wajib diisi',

                'pr_posisi.required' => 'Posisi wajib dipilih', 
            ]);

            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('admin123'),
                'role' => 'admin'
            ]);

            Profile::create([
                'user_id' => $user->id,
                'pr_nama' => $request->name,
                'pr_no_hp' => $request->pr_no_hp,
                'pr_alamat' => $request->pr_alamat,
                'pr_photo' => null,
                'pr_jenis_kelamin' => $request->pr_jenis_kelamin,
                'pr_tanggal_lahir' => $request->pr_tanggal_lahir,
                'pr_status' => $request->pr_status,
                'pr_posisi' => $request->pr_posisi,
            ]);

            DB::commit();

            return redirect()
                ->route('data-admin.index')
                ->with('success', 'Data admin berhasil ditambahkan');

        } catch (ValidationException $e) {

            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Periksa kembali input anda');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function edit($id)
{
    $user = User::with(['profile.kampus'])->findOrFail($id);

    return response()->json([
        'data' => $user
    ]);
}



public function update(Request $request, $id)
{
    if (!$request->expectsJson()) {
        abort(400, 'Invalid request type');
    }

    try {

        $data = $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|email',

            'pr_no_hp' => 'required',
            'pr_posisi' => 'required',
            'pr_jenis_kelamin' => 'required',
            'pr_tanggal_lahir' => 'required',
            'pr_alamat' => 'required',
            'pr_status' => 'required',

        ], [

            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',

            'pr_no_hp.required' => 'No HP wajib diisi',
            'pr_posisi.required' => 'Posisi wajib dipilih',
            'pr_jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'pr_tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'pr_alamat.required' => 'Alamat wajib diisi',
            'pr_status.required' => 'Status wajib diisi',
        ]);

        DB::beginTransaction();

        $user = User::findOrFail($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $ttl = Carbon::createFromFormat('d/m/Y', $data['pr_tanggal_lahir'])->format('Y-m-d');

        $user->profile->update([
            'pr_no_hp' => $data['pr_no_hp'],
            'pr_posisi' => $data['pr_posisi'],
            'pr_jenis_kelamin' => $data['pr_jenis_kelamin'],
            'pr_tanggal_lahir' => $ttl,
            'pr_alamat' => $data['pr_alamat'],
            'pr_status' => $data['pr_status'],
        ]);
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data admin berhasil diupdate'
        ], 200);

    } catch (ValidationException $e) {

        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);

    } catch (\Throwable $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
        ], 500);
    }
}


        public function toggleStatus($id)
        {
            $user = User::with('profile')->findOrFail($id);

            $user->profile->update([
                'pr_status' => $user->profile->pr_status == 'Aktif'
                    ? 'Nonaktif'
                    : 'Aktif'
            ]);

            return response()->json(['success'=>true]);
        }

        public function destroy($id)
        {
            try {

                $user = User::with('profile')->findOrFail($id);

                // hapus profile dulu
                if($user->profile){
                    $user->profile->delete();
                }

                // hapus user
                $user->delete();

                return response()->json([
                    'message' => 'Data admin berhasil dihapus'
                ]);

            } catch (\Exception $e) {

                return response()->json([
                    'message' => 'Gagal menghapus data'
                ], 500);
            }
        }

}
