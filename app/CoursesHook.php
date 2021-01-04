<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class CoursesHook extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'courses_hooks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'requirements',
        'link',
        'priorized',
        'educational_level',
        'growinghook',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const EDUCATIONAL_LEVEL_SELECT = [
        'Informal'    => 'Sin estudios formales',
        'Primaria'    => 'Primaria',
        'Secundaria'  => 'Secundaria',
        'Técnico'     => 'Técnico',
        'Tecnólogo'   => 'Tecnólogo',
        'Profesional' => 'Profesional',
        'Posgrado'    => 'Posgrado',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function courseshooksCourses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function rols()
    {
        return $this->belongsToMany(Role::class);
    }
}
