<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $table = 'supervisors';
    protected $primaryKey = 'sp_id'; // WAJIB: Biar Laravel tahu PK-nya sp_id
    public $incrementing = false;     // Karena pakai UUID
    protected $keyType = 'string';    // Karena UUID itu string

    protected $fillable = [
        'sp_id', 'sp_nip', 'sp_nama', 'sp_jabatan', 'sp_divisi', 'sp_email', 'sp_telepon'
    ];
}
