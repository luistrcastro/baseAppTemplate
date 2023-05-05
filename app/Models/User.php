<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use App\Traits\HashedId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use HashedId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'full_name',
        'picture_url',
        'email',
        'receives_browser_notifications',
        'receives_email_notifications',
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
        'first_name' =>'string',
        'middle_name' =>'string',
        'last_name' =>'string',
        'full_name' =>'string',
        'picture_url' =>'string',
        'email' =>'string',
        'receives_browser_notifications' =>'boolean',
        'receives_email_notifications' =>'boolean',
        'email_verified_at' => 'datetime',
    ];
}
