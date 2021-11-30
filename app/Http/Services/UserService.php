<?php

namespace App\Http\Services;

use App\Models\UserModel;
use Illuminate\Support\Facades\Cache;

class UserService
{
    protected $jwt;
    public function __construct(JsonWebToken $jwt) {
        $this->jwt = $jwt;
    }
    public function userLogin($userName,$userPwd) {
        $userInfo = UserModel::where("user_name",$userName)->where("user_pwd",$userPwd)->first()->toArray();
        if([] == $userInfo) {
            return false;
        }
        $token = $this->jwt->makeToken($userInfo["id"]);
        try {
            Cache::tags(["userLogin"])->put($token,$userInfo["id"],86400 * 3);
        } catch (\Exception $e) {
            return false;
        }
        return $token;
    }
}
