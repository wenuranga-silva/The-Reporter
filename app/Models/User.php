<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LakM\Comments\Concerns\Commenter;
use LakM\Comments\Contracts\CommenterContract;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, CommenterContract
{
    use HasFactory, Notifiable ,HasRoles ,LogsActivity ,Commenter;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    //// only for deleting & updating
    protected static $recordEvents = ['deleted'];

    /// create a log for user activities
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'email' ,'id'])
        ->useLogName('user');
        // Chain fluent methods for configuration options
    }

    public function userDesc() {

        ///// only form admin / writer
        return $this->hasOne(UserDescription::class ,'author' ,'id');
    }
}
