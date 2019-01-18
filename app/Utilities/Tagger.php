<?php
namespace App\Utilities;

use App\Models\Tag;
use Illuminate\Support\Facades\Log;


class Tagger
{
    public static function tagCafe($cafe, $tags, $user_id)
    {
        // 遍历标签数据，分别存储每个标签，并建立其余咖啡店的关联
        foreach ($tags as $tag) {
            $name = trim($tag);
            // 若标签已经存在，则直接获取其实例
            $newCafeTag = Tag::firstOrNew(['name' => $name]);
            $newCafeTag->name = $name;
            $newCafeTag->save();
            // Log::info('[MYDEBUG]' . $name . ' ID: ' . $newCafeTag->id);
            // 将标签和咖啡店关联起来
            $cafe->tags()->syncWithoutDetaching([$newCafeTag->id => ['user_id' => $user_id]]);
        }
    }
}