<?php

namespace App\Http\Services;

use App\Models\AdjectiveModel;
use App\Models\ModalParticleModel;
use App\Models\NounModel;
use App\Models\VerbModel;

/**
 * 上传文章组件
 */
class UpdateArticleComponent
{
    protected $requestData;
    public function __construct() {
        $this->requestData = request()->all();
    }
    public function insert($type,$contentArr)
    {
        switch ($type) {
            case "adjective":
                $model = new AdjectiveModel();
                break;
            case "modal_particle":
                $model = new ModalParticleModel();
                break;
            case "noun":
                $model = new NounModel();
                break;
            case "verb":
                $model = new VerbModel();
                break;
            default:
                return "必填参数有误";
                break;
        }
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
        unset($value);
        $insertResult = $model->insert($data);
        return $insertResult;
    }
}
