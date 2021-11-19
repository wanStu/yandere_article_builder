<?php

namespace App\Http\Services\Component;

use App\Models\ModalParticleModel;
use App\Models\NounModel;
use App\Models\VerbModel;
use App\Models\AdjectiveModel;

class Component
{
    protected $requestData;
    public function __construct() {
        $this->requestData = request()->all();
    }
    public function insert()
    {
        if(!isset($this->requestData["content"]) || !isset($this->requestData["type"])) {
            return "缺失必填参数";
        }
        switch ($this->requestData["type"]) {
            case adjective:
                $model = new AdjectiveModel();
                break;
            case modalparticle:
                $model = new ModalParticleModel();
                break;
            case noun:
                $model = new NounModel();
                break;
            case verb:
                $model = new VerbModel();
                break;
            default:
                break;
        }
        $contentArr = explode(",",$this->requestData["content"]);
        $repetitionField = $model->where("is_delete",0)->whereIn("content",$contentArr)->pluck("content")->toArray();
        $data = [];
        foreach ($contentArr as $value) {
            if(in_array($value,(array)$repetitionField)) {
                continue;
            }
            $data[] = [
                "content"       => $value,
                "create_time"   => time(),
                "update_time"   => time()
            ];
        }
        $insertResult = $model->insert($data);
        unset($value);
        if($insertResult) {
            return json_encode([200,"成功",true]);
        }
    }
}
