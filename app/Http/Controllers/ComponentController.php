<?php

namespace App\Http\Controllers;

use App\Http\Services\CommonService;
use App\Http\Services\GetArticleComponentService;
use App\Http\Services\UpdateArticleComponentService;

class ComponentController
{
    protected $update;
    protected $get;
    protected $requestData;
    public function __construct(UpdateArticleComponentService $updateArticleComponent, GetArticleComponentService $getArticleComponent, CommonService $common) {
        $this->requestData = request()->all();
        $this->update = $updateArticleComponent;
        $this->get = $getArticleComponent;
        $this->common = $common;
    }

    /**
     * 插入词
     * @return false|string
     */
    public function insert() {
        $data = ["type","content"];
        $missParam = $this->common->getMissParam($this->requestData,$data);
        if($missParam) {
            return $this->common->returnJson(400,"有必填参数为空",false);
        }
        try {
            $insertResult = $this->update->insert($this->requestData["type"],explode(",",$this->requestData["content"]));
        }catch (\Exception $e) {
            return $this->common->returnJson(400,"出错",$e->getMessage());
        }
        if($insertResult) {
            return $this->common->returnJson(200,"成功",true);
        }else {
            return $this->common->returnJson(400,"出错",false);
        }
    }

    /**
     * 获取词
     * @return false|string
     */
    public function getList() {
        $data = ["type"];
        $missParam = $this->common->getMissParam($this->requestData,$data);
        if($missParam) {
            return $this->common->returnJson(400,"有必填参数为空",false);
        }
        try {
            $list = $this->get->getComponent($this->requestData["type"]);
        }catch (\Exception $e) {
            return $this->common->returnJson(400,"出错",$e->getMessage());
        }
        if($list) {
            return $this->common->returnJson(200,"成功",$list);
        }else {
            return $this->common->returnJson(400,"出错",false);
        }
    }
}
