<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function getUser()
    {
        return Auth::guard('api')->user();
    }
}
