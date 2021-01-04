<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Tag extends Model
{
    use SoftDeletes;

    public $table = 'tags';

    public static $searchable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function tagsBackgroundProcesses()
    {
        return $this->belongsToMany(BackgroundProcess::class);
    }

    public function tagsReferenceObjects()
    {
        return $this->belongsToMany(ReferenceObject::class);
    }
}
