<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class ChallengesUser extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'challenges_users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'Enviado'   => 'Enviado',
        'Entregado' => 'Entregado',
        'Abandono'  => 'Abandono',
    ];

    protected $fillable = [
        'challenge_id',
        'courseschedule',
        'user_id',
        'referencetype_id',
        'reference_text',
        'reference_media',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referencetype()
    {
        return $this->belongsTo(ReferenceType::class, 'referencetype_id');
    }
}
