<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pekerjaan extends Model
{
    protected $table = 'ms_pekerjaan';

    protected $primaryKey = 'pk_id_pekerjaan';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pk_id_pekerjaan',
        'pk_kode_tipe_pekerjaan',
        'pk_nama_pekerjaan',
        'pk_deskripsi_pekerjaan',
        'pk_level_pekerjaan',
        'pk_estimasi_durasi_hari',
        'pk_minimal_skill',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->pk_id_pekerjaan) {
                $model->pk_id_pekerjaan = (string) Str::uuid();
            }
        });
    }
}
