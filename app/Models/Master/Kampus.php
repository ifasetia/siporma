<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kampus extends Model
{
    protected $table = 'ms_kampus';

    protected $primaryKey = 'km_id';

    public $incrementing = false; // 🔥 UUID bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'km_id',
        'km_nama_kampus',
        'km_kode_kampus',
        'km_email',
        'km_alamat',
        'km_telepon',
        'km_foto',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->km_id) {
                $model->km_id = (string) Str::uuid();
            }
        });
    }
}
