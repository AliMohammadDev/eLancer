<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function freeLancer()
    {
        return $this->hasOne(FreeLancer::class, 'user_id', 'id')
            ->withDefault();
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'freelancer_id', 'id');
    }

    // Accessor Method
    // $user->profile_photo_url
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->freelancer->profile_photo_path) {
            return asset('storage/'.$this->freelancer->profile_photo_path);
        }

        return asset('images/default-photo.jpg');
    }

    // $this->name
    public function getNameAttribute($value)
    {
        return Str::title($value);
    }

    // Mutators
    // $user->email = "M@Safadi.ps" -> "m@safadi.ps"
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Str::lower($value);
    }

    public function proposedProjects()
    {
        return $this->belongsToMany(
            Project::class,
            'proposals',
            'freelancer_id',
            'project_id'
        )->withPivot([
            'description',
            'cost',
            'duration',
            'duration_unit',
            'status',
        ]);
    }

    public function contractedProjects()
    {
        return $this->belongsToMany(
            Project::class,
            'contracts',
            'freelancer_id',
            'project_id'
        )->withPivot([
            'proposal_id',
            'cost',
            'type',
            'start_on',
            'end_on',
            'completed_on',
            'hours',
            'status',
        ]);
    }
}
