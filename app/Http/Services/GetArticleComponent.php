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
     * 获取单独类型的词条
     * @param $type
     * @return string
     */
    public function getComponent($type) {
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
