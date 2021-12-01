<?php

namespace App\Http\Services;

use App\Models\AdjectiveModel;
use App\Models\AuxiliaryModel;
use App\Models\ModalParticleModel;
use App\Models\NounModel;
use App\Models\PersonalPronounModel;
use App\Models\PuncListModel;
use App\Models\VerbModel;

/**
 * 上传文章组件
 */
class UpdateArticleComponentService
{
    protected $requestData;
    public function __construct() {
        $this->requestData = request()->all();
    }

    /**
     * 获取模型实例
     * @param $type string 类型
     * @return AdjectiveModel|ModalParticleModel|NounModel|VerbModel|PuncListModel|PersonalPronounModel|AuxiliaryModel
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
            case "punc_list":
                return new PuncListModel();
            case "personal_pronoun":
                return new PersonalPronounModel();
            case "auxiliary":
                return new AuxiliaryModel();
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

    /**
     * 删除词
     * @param string $type
     * @param array $idAttr
     * @throws \Exception
     */
    public function delete(string $type, array $idAttr) {
        $model = $this->getModel($type);
        $deleteResult = $model->where("is_delete",0)->whereIn("id",$idAttr)->update(["is_delete" => 1,"delete_time" => time()]);
        if($deleteResult) {
            return true;
        }else {
            return false;
        }
    }
}
