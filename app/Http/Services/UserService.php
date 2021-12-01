<?php

namespace App\Http\Services;

use App\Models\UserModel;
use Illuminate\Support\Facades\Cache;

class UserService
{
    protected $jwt;
    public function __construct(JsonWebTokenService $jwt) {
        $this->jwt = $jwt;
    }

    /**
     * 用户登录
     * @param string $userName 用户名
     * @param string $userPwd 用户密码
     * @return false|string
     */
    public function userLogin($userName,$userPwd) {
        $userInfo = UserModel::where("user_name",$userName)->where("user_pwd",$userPwd)->first();
        if(!$userInfo) {
            return false;
        }
        $token = $this->jwt->makeToken($userInfo["id"]);
        if(!$token) {
            return false;
        }
        return $token;
    }

    /**
     * 新增用户
     * @param string $userName 用户名
     * @param string $userPwd 用户密码
     * @return bool
     */
    public function saveUser($userName,$userPwd) {
        $userinfo = UserModel::where("user_name",$userName)->where("user_pwd",$userPwd)->first();
        $saveResult = false;
        if(!$userinfo) {
            $saveResult = UserModel::insertGetId(
                [
                    "user_name"     => $userName,
                    "user_pwd"      => $userPwd,
                    "create_time"   => microtime()
                ]
            );
        }
        if($saveResult) {
            return $saveResult;
        }else {
            return false;
        }
    }

    /**
     * 编辑用户
     * @param int $userid 用户ID
     * @param array $userInfo 用户信息
     * @return bool
     */
    public function editUser($userid,array $userInfo) {
        $userinfo = UserModel::where("id",$userid)->first();
        $editResult = false;
        if($userinfo) {
            $editResult = $userinfo->update(
                [
                    "user_pwd"      => $userInfo["userPwd"],
                    "update_time"   => microtime()
                ]
            );
        }
        if($editResult) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * 删除用户
     * @param int $userid 用户ID
     * @return bool
     */
    public function deleteUser($userid) {
        $userinfo = UserModel::where("id",$userid)->first();
        $deleteResult = false;
        if($userinfo) {
            $deleteResult = $userinfo->update(
                [
                    "update_time"   => microtime(),
                    "is_delete"     => 1,
                    "delete_time"   => microtime()
                ]
            );
        }
        if($deleteResult) {
            return true;
        }else {
            return false;
        }
    }
}
