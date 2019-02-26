<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Company extends Model
{
    /**
     * 所属用户
     *
     * @return void
     */
    public function ownerBy()
    {
        return $this->belongsToMany(User::class, 'company_owners', 'company_id', 'user_id');
    }

    public function cafes()
    {
        return $this->hasMany(Cafe::class, 'company_id', 'id');
    }
}
