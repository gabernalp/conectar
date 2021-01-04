<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Department extends Model
{
    use SoftDeletes;

    public $table = 'departments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function departmentCities()
    {
        return $this->hasMany(City::class, 'department_id', 'id');
    }

    public function focalizacionTerritorialCourses()
    {
        return $this->belongsToMany(Course::class);
    }
}
