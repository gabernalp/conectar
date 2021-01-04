<?php

namespace App;

use App\Notifications\VerifyUserNotification;
use App\Traits\Auditable;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use \DateTimeInterface;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, Auditable;

    public $table = 'users';

    public static $searchable = [
        'document',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    const ZONA_SELECT = [
        'Rural'  => 'Rural',
        'Urbana' => 'Urbana',
    ];

    const GENDER_SELECT = [
        'Masculino' => 'Masculino',
        'Femenino'  => 'Femenino',
        'LGBTI'     => 'LGBTI',
    ];

    protected $dates = [
        'email_verified_at',
        'verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const ETNIA_SELECT = [
        'Afrocolombiano' => 'Afrocolombiano',
        'Indígena'       => 'Indígena',
        'Raizal'         => 'Raizal',
        'Rrom gitano'    => 'Rrom gitano',
        'Otro ND'        => 'Otro ND',
    ];

    const MODALITY_SELECT = [
        'Institucional' => 'Institucional',
        'Familiar'      => 'Familiar',
        'Comunidad'     => 'Comunidad',
        'Propia'        => 'Propia',
        'Intercultural' => 'Intercultural',
    ];

    const ACADEMIC_BACKGROUND_SELECT = [
        'Primaria'                 => 'Primaria',
        'Secundaria'               => 'Secundaria',
        'Técnico/Tecnólogo'        => 'Técnico/Tecnólogo',
        'Profesional'              => 'Profesional',
        'Especialización/Maestría' => 'Especialización/Maestría',
        'Doctorado'                => 'Doctorado',
        'Pos-doctorado'            => 'Pos-doctorado',
    ];

    protected $fillable = [
        'documenttype_id',
        'document',
        'name',
        'last_name',
        'gender',
        'email',
        'phone',
        'phone_2',
        'department_id',
        'city_id',
        'zona',
        'etnia',
        'academic_background',
        'min_age',
        'max_age',
        'modality',
        'newsletter_subscription',
        'email_verified_at',
        'password',
        'approved',
        'verified',
        'verified_at',
        'verification_token',
        'remember_token',
        'operator_id',
        'entity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified    = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token     = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token     = Str::random(64);
                    $usedToken = User::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');

                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }

                $user->notify(new VerifyUserNotification($user));
            }
        });
    }

    public function userFeedbacksUsers()
    {
        return $this->hasMany(FeedbacksUser::class, 'user_id', 'id');
    }

    public function userCoursesUsers()
    {
        return $this->hasMany(CoursesUser::class, 'user_id', 'id');
    }

    public function userChallengesUsers()
    {
        return $this->hasMany(ChallengesUser::class, 'user_id', 'id');
    }

    public function userMeetings()
    {
        return $this->hasMany(Meeting::class, 'user_id', 'id');
    }

    public function userUserChainBlocks()
    {
        return $this->hasMany(UserChainBlock::class, 'user_id', 'id');
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function tutorsCourseSchedules()
    {
        return $this->belongsToMany(CourseSchedule::class);
    }

    public function documenttype()
    {
        return $this->belongsTo(DocumentType::class, 'documenttype_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }
}
