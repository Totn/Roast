<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafePhoto extends Model
{
    protected $table = 'cafes_photos';

    /**
     * 定义与表cafe的关联
     *
     * @return void
     */
    public function cafe()
    {
        return $this->belongsTo(Cafe::class, 'cafe_id', 'id');
    }

    /**
     * 定义与表user的关系
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'uploaded_by', 'id');
    }
}
