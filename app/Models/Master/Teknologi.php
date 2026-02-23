<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Teknologi extends Model
{
    use HasFactory;

    protected $table = 'ms_teknologi';
    protected $primaryKey = 'tk_id';
    public $incrementing = false; // Beritahu Laravel ini bukan angka auto-increment
    protected $keyType = 'string'; // Beritahu Laravel tipe ID-nya adalah string

    protected $fillable = [
        'tk_id',
        'tk_nama',
        'tk_kategori',
    ];

    // Fungsi otomatis untuk generate UUID saat data baru dibuat
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
