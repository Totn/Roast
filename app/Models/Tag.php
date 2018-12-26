<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * 定义tags与cafes的关系
     *
     * @return void
     */
    public function cafes()
    {
        return $this->belongsToMany(Cafe::class, 'cafes_users_tags', 'tag_id', 'user_id');
    }
}
