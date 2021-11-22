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

    /**
     * 获取模型实例
     * @param $type string 类型
     * @return AdjectiveModel|ModalParticleModel|NounModel|VerbModel
     * @throws \Exception
     */
    protected function getModel($type) {
        switch ($type) {
            case "adjective":
                return new AdjectiveModel();
            case "modal_particle":
                return new ModalParticleModel();
            case "noun":
                return new NounModel();
            case "verb":
                return new VerbModel();
            default:
                throw new \Exception("类型错误，请及时联系网站管理员");
        }
    }

    /**
     * 插入新词
     * @param $type string 类型
     * @param $contentArr array 词数组
     * @return string
     */
    public function insert($type,$contentArr)
    {
        $model = $this->getModel($type);
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

    public function delete($type,$idAttr) {
        $model = $this->getModel($type);
        $model->where("is_delete",0)->whereIn("id",$idAttr)->save(["is_delete" => 1]);
    }
}
