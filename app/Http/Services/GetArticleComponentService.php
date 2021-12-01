<?php

namespace App\Http\Services;

use App\Models\ComponentModel;

/**
 * 获取文章各个组成部分的列表
 */
class GetArticleComponentService
{

    /**
     * 获取单独类型的词条
     * @param $type
     * @return string
     */
    public function getComponent($type) {
        $model = new ComponentModel();
        $component = $model->where("type",$type)->where("is_delete",0)->where("content","<>","")->select("id","content")->get();
        return $component;
    }
    /**
     * 返回所有文章组件
     */
    public function getAssemble() {
        $verbList = $this->getComponent(1)->pluck("content"); //动词
        $adjectiveList = $this->getComponent(2)->pluck("content"); //形容词
        $modalParticleList = $this->getComponent(3)->pluck("content"); //语气助词
        $nounList = $this->getComponent(4)->pluck("content"); //名词
        $puncList = $this->getComponent(5)->pluck("content"); //标点
        $personalPronounList = $this->getComponent(6)->pluck("content"); //人称代词
        $auxiliaryList = $this->getComponent(7)->pluck("content"); //是
        return compact("adjectiveList","modalParticleList","nounList","verbList","puncList","personalPronounList","auxiliaryList");
    }
}
