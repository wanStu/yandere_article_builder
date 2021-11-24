<?php

namespace App\Http\Controllers;

use App\Http\Services\common;
use App\Http\Services\GetArticleComponent;
use App\Http\Services\UpdateArticleComponent;

class ComponentController
{
    protected $update;
    protected $get;
    protected $requestData;
    public function __construct(UpdateArticleComponent $updateArticleComponent,GetArticleComponent $getArticleComponent,common $common) {
        $this->requestData = request()->all();
        $this->update = $updateArticleComponent;
        $this->get = $getArticleComponent;
        $this->common = $common;
    }
    public function insert() {
        try {
            $insertResult = $this->update->insert($this->requestData["type"],explode(",",$this->requestData["content"]));
        }catch (\Exception $e) {
            return $this->common->returnJson(400,"出错",$e->getMessage());
        }
        if($insertResult) {
            return $this->common->returnJson(200,"成功",true);
        }
    }
    public function getList() {
        try {
            $list = $this->get->getComponent($this->requestData["type"]);
        }catch (\Exception $e) {
            return $this->common->returnJson(400,"出错",$e->getMessage());
        }
        return $this->common->returnJson(200,"成功",$list);
    }
}
