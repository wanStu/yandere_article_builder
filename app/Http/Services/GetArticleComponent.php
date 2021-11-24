<?php

namespace App\Http\Services;

use App\Models\AdjectiveModel;
use App\Models\ModalParticleModel;
use App\Models\NounModel;
use App\Models\AuxiliaryModel;
use App\Models\PersonalPronounModel;
use App\Models\PuncListModel;
use App\Models\VerbModel;

/**
 * 获取文章各个组成部分的列表
 */
class GetArticleComponent
{

    /**
     * 获取模型实例
     * @param $type string 类型
     * @return AdjectiveModel|ModalParticleModel|NounModel|VerbModel|PuncListModel|AuxiliaryModel|PersonalPronounModel
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
     * 获取单独类型的词条
     * @param $type
     * @return string
     */
    public function getComponent($type) {
        $model = $this->getModel($type);
        $component = $model->where("is_delete",0)->where("content","<>","")->select("id","content")->get();
        return $component;
    }
    /**
     * 返回所有文章组件
     */
    public function getAssemble() {
        $adjectiveList = $this->getComponent("adjective")->pluck("content"); //形容词
        $modalParticleList = $this->getComponent("modal_particle")->pluck("content"); //语气词
        $nounList = $this->getComponent("noun")->pluck("content"); //名词
        $verbList = $this->getComponent("verb")->pluck("content"); //动词
        $puncList = $this->getComponent("punc_list")->pluck("content"); //标点
        $personalPronounList = $this->getComponent("personal_pronoun")->pluck("content"); //人称代词
        $auxiliaryList = $this->getComponent("auxiliary")->pluck("content"); //是
        return compact("adjectiveList","modalParticleList","nounList","verbList","puncList","personalPronounList","auxiliaryList");
    }
}
