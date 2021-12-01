<?php

namespace App\Http\Controllers;
use App\Http\Services\CommonService;
use App\Http\Services\UserService;

class LoginController
{
    protected $common;
    protected $requestData;
    protected $userService;
    public function __construct(CommonService $common, UserService $userService) {
        $this->requestData = request()->all();
        $this->common = $common;
        $this->userService = $userService;
    }
    //登录
    public function login() {
        $data = ["username","userpwd"];
        $missParam = $this->common->getMissParam($this->requestData,$data);
        if($missParam) {
            return $this->common->returnJson(400,"有必填参数为空",false);
        }
        $loginResult = $this->userService->userLogin($this->requestData["username"],$this->requestData["userpwd"]);
        if(!$loginResult) {
            return $this->common->returnJson(400,"账号或密码错误，登陆失败",false);
        }
        return $this->common->returnJson(200,"登陆成功",$loginResult);
    }
    //注销登录
    public function logout() {

    }
}
