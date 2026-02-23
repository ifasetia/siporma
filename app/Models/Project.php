<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ProjectLink;
use App\Models\ProjectPhoto;
use App\Models\ProjectMember;

class Project extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
    'id',
    'title',
    'description',
    'technologies',
    'status',
    'created_by',
];

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $model->id = (string) \Illuminate\Support\Str::uuid();
    });
}

public function links()
{
    return $this->hasMany(ProjectLink::class);
}

public function photos()
{
    return $this->hasMany(ProjectPhoto::class);
}

public function members()
{
    return $this->hasMany(ProjectMember::class);
}
}
