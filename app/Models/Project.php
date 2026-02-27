<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ProjectLink;
use App\Models\ProjectPhoto;
use App\Models\ProjectMember;
use App\Models\Master\StatusProyek;

class Project extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
    'id',
    'title',
    'description',
    'status_id',
    'created_by',
];

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $model->id = (string) \Illuminate\Support\Str::uuid();
    });
}

public function masterStatus()
{
    return $this->belongsTo(\App\Models\Master\StatusProyek::class, 'status_id', 'sp_id');
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
    return $this->belongsToMany(User::class, 'project_members')
                ->withTimestamps();
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function files()
{
    return $this->hasMany(ProjectFile::class);
}

public function teknologis()
{
    return $this->belongsToMany(
        \App\Models\Master\Teknologi::class,
        'project_teknologi',
        'project_id',
        'teknologi_id'
    );
}

public function collaborators()
{
    return $this->belongsToMany(
        \App\Models\User::class,
        'project_members',
        'project_id',
        'user_id'
    );
}
const STATUS_MENUNGGU = 'menunggu';
const STATUS_DISETUJUI = 'disetujui';
const STATUS_REVISI = 'revisi';

}
