<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
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
        'image',
        'phone'
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


    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->email == 'admin@gmail.com' ;
    }


    public function getImageAttribute($value)
    {
        return $value ?: asset('images/default-user.jpg');
    }



    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

  
    protected static function booted()
    {
        static::created(function ($user) {
            activity()
                ->performedOn($user)
                ->causedBy(auth()->user())
                ->withProperties(['attributes' => $user->getAttributes()])
                ->log('User created');
        });
    }


}
