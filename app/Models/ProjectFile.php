<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectFile extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'project_id',
        'file_path',
        'file_type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}