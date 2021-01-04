<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Role extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function rolesCourses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function rolCoursesHooks()
    {
        return $this->belongsToMany(CoursesHook::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
