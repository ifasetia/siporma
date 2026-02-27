<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Kampus;
use App\Models\Master\Jurusan;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $primaryKey = 'pr_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pr_id',
        'user_id',
        'pr_km_id',
        'pr_js_id',
        'pr_id_pekerjaan',
        'pr_sp_id',


        'pr_nip',
        'pr_nim',
        'pr_nama',
        'pr_no_hp',
        'pr_alamat',
        'pr_photo',
        'pr_jenis_kelamin',
        'pr_tanggal_lahir',
        'pr_status',

        'pr_internship_start',
        'pr_internship_end',
        'pr_posisi',

        'pr_instagram',
        'pr_linkedin',
        'pr_github',
        'pr_whatsapp',
        'pr_facebook',
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // RELASI KE MASTER KAMPUS
    public function kampus()
    {
        return $this->belongsTo(Kampus::class,'pr_km_id','km_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class,
            'pr_id_pekerjaan',
            'pk_id_pekerjaan'
        );
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class,
            'pr_js_id',
            'js_id'
        );
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Supervisors::class,
            'sp_id',
            'sp_id'
        );
    }
    

}
