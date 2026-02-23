<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jurusan extends Model

{
    protected $table = 'ms_jurusan';

    protected $primaryKey = 'js_id';

    public $incrementing = false; // 🔥 UUID bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'js_nama',
        'js_kode',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->js_id) {
                $model->js_id = (string) Str::uuid();
            }
        });
    }

}
