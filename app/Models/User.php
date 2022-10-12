<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'panel_login',
        'password',
        'avatar',
        'remember_token',
        'about'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function getAboutAttribute($value){
        return $value ? json_decode($value) : false;
    }

    public function getAvatarAttribute($value){
        if($value){
            return $value;
        } else {
            return 'avatars/default-avatar.jpg';
        }
    }

    public function favorites(){
        return $this->belongsTo(Favorite::class, 'user_id', 'id');
    }
}
