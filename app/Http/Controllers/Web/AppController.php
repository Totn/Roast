<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AppController extends Controller
{
    public function getApp()
    {
        return view('app');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }
    // 移除旧登录方法
    // public function getLogin()
    // {
    //     return view('login');
    // }
}
