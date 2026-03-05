<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectPhoto extends Model
{
    protected $fillable = [
        'id',
        'project_id',
        'photo',
    ];

    protected $keyType = 'string';   // 🔥 WAJIB
    public $incrementing = false;    // 🔥 WAJIB

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }

        });
    }
}
