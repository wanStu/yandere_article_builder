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
     * 获取形容词
     */
    public function getAdjective() {
        return AdjectiveModel::where("is_delete",0)->get();
    }

    /**
     * 获取语气助词
     * @return mixed
     */
    public function getModalParticle() {
        return ModalParticleModel::where("is_delete",0)->get();
    }

    /**
     * 获取名词
     * @return mixed
     */
    public function getNoun() {
        return NounModel::where("is_delete",0)->get();
    }

    /**
     * 获取动词
     * @return mixed
     */
    public function getVerb() {
        return VerbModel::where("is_delete",0)->get();
    }

    /**
     * 返回所有文章组件
     */
    public function getAssemble() {
        $adjectiveList = $this->getAdjective();
        $modalParticleList = $this->getModalParticle();
        $nounList = $this->getNoun();
        $verb = $this->getVerb();
        dd($adjectiveList->items);
        return json_encode(compact("adjectiveList","modalParticleList","nounList","verb"));
    }
}
