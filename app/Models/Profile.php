<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

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

        'pr_nim',
        'pr_kampus',
        'pr_jurusan',
        'pr_internship_start',
        'pr_internship_end',
        'pr_supervisor_name',
        'pr_supervisor_contact',

        'pr_posisi',
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
