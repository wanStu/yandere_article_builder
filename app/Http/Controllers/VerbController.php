<?php

namespace App\Http\Controllers;

use App\Http\Services\Component;
use App\Http\Services\GetArticleComponent;
use App\Http\Services\UpdateArticleComponent;

class VerbController implements Component
{
    protected $update;
    protected $get;
    protected $requestData;
    public function __construct(UpdateArticleComponent $updateArticleComponent,GetArticleComponent $getArticleComponent) {
        $this->requestData = request()->all();
        $this->update = $updateArticleComponent;
        $this->get = $getArticleComponent;
    }
    public function insert() {
        $insertResult = $this->update->insert("verb",explode(",",$this->requestData["content"]));
        if($insertResult) {
            return json_encode(["status" => 200,"message" => "成功","data" => true],JSON_UNESCAPED_UNICODE);
        }
    }
    public function getList() {
        $assemble = $this->get->getComponent("verb");
        return $assemble;
    }
}
