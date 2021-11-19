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
        return AdjectiveModel::pluck("content");
    }

    /**
     * 获取语气助词
     * @return mixed
     */
    public function getModalParticle() {
        return ModalParticleModel::pluck("content");
    }

    /**
     * 获取名词
     * @return mixed
     */
    public function getNoun() {
        return NounModel::pluck("content");
    }

    /**
     * 获取动词
     * @return mixed
     */
    public function getVerb() {
        return VerbModel::pluck("content");
    }

    /**
     * 返回所有文章组件
     */
    public function getAssemble() {
        $adjectiveList = $this->getAdjective();
        $modalParticleList = $this->getModalParticle();
        $nounList = $this->getNoun();
        $verb = $this->getVerb();
        return json_encode(compact("adjectiveList","modalParticleList","nounList","verb"));
    }
}
