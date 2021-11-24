<?php

namespace App\Http\Controllers;

use App\Http\Services\Component;
use App\Http\Services\GetArticleComponent;
use App\Http\Services\UpdateArticleComponent;

class ModalParticleController implements Component
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
        try {
            $insertResult = $this->update->insert("modal_particle",explode(",",$this->requestData["content"]));
        }catch (\Exception $e) {
            return json_encode(["status" => 400,"message" => "出错","data" => $e->getMessage()],JSON_UNESCAPED_UNICODE);
        }
        if($insertResult) {
            return json_encode(["status" => 200,"message" => "成功","data" => true],JSON_UNESCAPED_UNICODE);
        }
    }

    public function getList() {
        try {
            $list = $this->get->getComponent("modal_particle");
        }catch (\Exception $e) {
            return json_encode(["status" => 400,"message" => "出错","data" => $e->getMessage()],JSON_UNESCAPED_UNICODE);
        }
        return json_encode(["status" => 200,"message" => "成功","data" => $list],JSON_UNESCAPED_UNICODE);
    }
}
