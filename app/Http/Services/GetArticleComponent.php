<?php

namespace App\Http\Services;

use App\Models\AdjectiveModel;
use App\Models\ModalParticleModel;
use App\Models\NounModel;
use App\Models\VerbModel;

/**
 * 获取文章各个组成部分的列表
 */
class GetArticleComponent
{

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
     * 获取单独类型的词条
     * @param $type
     * @return string
     */
    public function getComponent($type) {
        $model = $this->getModel($type);
        $component = $model->where("is_delete",0)->select("id","content")->get();
        return $component;
    }
    /**
     * 返回所有文章组件
     */
    public function getAssemble() {
        $adjectiveList = $this->getComponent("adjective");
        $modalParticleList = $this->getComponent("modal_particle");
        $nounList = $this->getComponent("noun");
        $verb = $this->getComponent("verb");
        return compact("adjectiveList","modalParticleList","nounList","verb");
    }
}
