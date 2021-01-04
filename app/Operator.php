<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Operator extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'operators';

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
        'nit',
        'observaciones',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function operatorContracts()
    {
        return $this->hasMany(Contract::class, 'operator_id', 'id');
    }

    public function operatorUsers()
    {
        return $this->hasMany(User::class, 'operator_id', 'id');
    }

    public function operatorsCourses()
    {
        return $this->belongsToMany(Course::class);
    }
}
