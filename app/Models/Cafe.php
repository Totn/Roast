<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Cafe extends Model
{

    // 定义咖啡店与冲泡方法间的关联关系
    public function brewMethods()
    {
        // 第一个参数：多对多关联的Model类名
        // 第二个参数：多对多的中间表名
        // 第三个参数：定义关联关系模型的外键名称
        // 第四个参数：要连接到的模型的外键名称
        return $this->belongsToMany(BrewMethod::class, 'cafes_brew_methods', 'cafe_id', 'brew_method_id');
    }

    // 与User间的多对多关系
    public function likes()
    {
        return $this->belongsToMany(User::class, 'users_cafes_likes', 'user_id', 'cafe_id');
    }

    /**
     * 咖啡店与标签之间的关系
     *
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'cafes_users_tags', 'cafe_id', 'tag_id');
    }
}
