<?php

// 1. Sesuaikan namespace dengan lokasi folder
namespace App\Models\Master;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusProyek extends Model
{
    use HasFactory, HasUuids;

    // Nama tabel di database (sesuaikan dengan migration)
    protected $table = 'master_status_proyek';

    protected $primaryKey = 'sp_id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sp_id',
        'sp_nama_status',
        'sp_warna',
        'sp_keterangan',
    ];
}
