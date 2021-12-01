<?php

namespace App\Http\Controllers;
use App\Http\Services\CommonService;
use App\Http\Services\UserService;

class UserController
{
    protected $userService;
    protected $requestData;
    protected $common;
    public function __construct(UserService $userService, CommonService $common) {
        $this->requestData = request()->all();
        $this->userService = $userService;
        $this->common = $common;
    }

    /**
     * 新增用户
     * @return false|string
     */
    public function addUser() {
        $data = ["username","userPwd"];
        $missParam = $this->common->getMissParam($this->requestData,$data);
        if($missParam) {
            return $this->common->returnJson(400,"有必填参数为空",false);
        }
        $addResult = $this->userService->saveUser($this->requestData["username"],$this->requestData["userPwd"]);
        if($addResult) {
            return $this->common->returnJson(200,"添加成功",$addResult);
        }else {
            return $this->common->returnJson(400,"添加失败",false);
        }
    }

    /**
     * 编辑用户,目前没有 用户档案 只能编辑 密码
     * @return false|string
     */
    public function editUser() {
        $data = ["id","userPwd"];
        $missParam = $this->common->getMissParam($this->requestData,$data);
        if($missParam) {
            return $this->common->returnJson(400,"有必填参数为空",false);
        }
        $editResult = $this->userService->editUser($this->requestData["id"],$this->requestData);
        if($editResult) {
            return $this->common->returnJson(200,"编辑成功",true);
        }else {
            return $this->common->returnJson(400,"编辑失败",false);
        }
    }

    /**
     * 删除用户,软删除
     * @return false|string
     */
    public function delUser() {
        $data = ["id","userPwd"];
        $missParam = $this->common->getMissParam($this->requestData,$data);
        if($missParam) {
            return $this->common->returnJson(400,"有必填参数为空",false);
        }
        $delResult = $this->userService->deleteUser($this->requestData["id"]);
        if($delResult) {
            return $this->common->returnJson(200,"删除成功",true);
        }else {
            return $this->common->returnJson(400,"删除失败",false);
        }
    }
}
