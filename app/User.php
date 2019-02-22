<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\Cafe;
use App\Models\CafePhoto;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 与 cafe间的多对多
    public function likes()
    {
        return $this->belongsToMany(Cafe::class, 'users_cafes_likes', 'user_id', 'cafe_id');
    }

    /**
     * 定义与cafe_photos的关系
     *
     * @return void
     */
    public function cafePhotos()
    {
        return $this->hasMany(CafePhoto::class, 'uploaded_by', 'id');
    }
}
