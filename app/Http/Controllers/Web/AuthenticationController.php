<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthenticationController extends Controller
{
    /**
     * 第三方登陆的重定向
     *
     * @param [type] $account
     * @return void
     */
    public function getSocialRedirect($account)
    {
        try {
            return Socialite::with($account)->redirect();
        } catch (\InvalidArgumentException $th) {
            return redirect('/login');
        }
    }

    /**
     * 第三方的登陆的回调
     *
     * @return void
     */
    public function getSocialCallback($account)
    {
        // Log::info('account' . $account);
        // 从第三方OAuth回调中获取用户信息
        $socialUser = Socialite::with($account)->user();
        // 在本地users表中查询该用户来判断是否存在
        $user = User::where('provider_id', '=', $socialUser->id)
            ->where('provider', '=', $account)
            ->first();
    
        if ($user == null) {
            // 若该用户不存在则保存到User表
            $newUser = new User();

            $newUser->name = $socialUser->getName() ?: '';
            $newUser->email = $socialUser->getEmail() == '' ? '' : $socialUser->getEmail();
            $newUser->avatar = $socialUser->getAvatar();
            $newUser->password = '';
            $newUser->provider = $account;
            $newUser->provider_id = $socialUser->getId();

            $newUser->save();

            $user = $newUser;
        }

        // 手动登陆
        Auth::login($user);

        // 登陆成功重定向
        return redirect('/');
    }
}
