<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    protected $fillable = [
        'role_id',
        'login',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    //создание связей
    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function userInfo(){
        return $this->hasOne(UserInfo::class, 'user_id');
    }
    public function portfolio(){
        return $this->hasMany(Portfolio::class, 'user_id');
    }
    public function equipment(){
        return $this->hasMany(Equipment::class, 'user_id');
    }
    public function services(){
        return $this->hasMany(Service::class, 'user_id');
    }
    public function favoriteServices(){
        return $this->hasMany(FavoriteService::class, 'user_id');
    }
    public function reviewLikes(){
        return $this->hasMany(ReviewLike::class, 'user_id');
    }
    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }
}
