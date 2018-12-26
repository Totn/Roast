<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagsController extends Controller
{
    /**
     * 为标签搜索框提供数据，实现标签的模糊搜索
     *
     * @return void
     */
    public function getTags()
    {
        $query = Request::get('search');

        if ($query === null || $query === '') {
            $tags = Tag::all();
        } else {
            $tags = Tag::where('name', 'LIKE', $query . "%")->get();
        }

        return response()->json($tags);
    }
}
