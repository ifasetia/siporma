<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Kampus;

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
        'pr_nama',
        'pr_no_hp',
        'pr_alamat',
        'pr_photo',
        'pr_jenis_kelamin',
        'pr_tanggal_lahir',
        'pr_status',
        'pr_nip',
        'pr_pekerjaan_id',

        'pr_nim',
        'pr_kampus_id',
        'pr_kampus',
        'pr_jurusan',
        'pr_internship_start',
        'pr_internship_end',
        'pr_supervisor_name',
        'pr_supervisor_contact',
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
        return $this->belongsTo(Master\Kampus::class,'pr_kampus_id','km_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(\App\Models\Master\Pekerjaan::class,
            'pr_pekerjaan_id',
            'pk_id_pekerjaan'
        );
    }

    public function jurusan()
    {
        return $this->belongsTo(\App\Models\Master\Jurusan::class,
            'pr_jurusan',
            'js_id'
        );
    }




}
