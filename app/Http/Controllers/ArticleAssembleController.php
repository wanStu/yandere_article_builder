<?php

namespace App\Http\Controllers;
use App\Http\Services\GetArticleComponentService;
use App\Http\Services\CommonService;
/**
 * 文章组装
 */
class ArticleAssembleController
{
    protected $getArticleComponent;
    protected $requestParam;
    protected $common;
    protected $articleMmodule;
    protected $nounSum;             //名词数量
    protected $puncSum;             //标点数量
    protected $modalParticleSum;    //语气词数量
    protected $adjectiveSum;        //形容词数量
    protected $verbSum;             //名词数量
    protected $auxiliarySum;        //助词数量
    protected $personalPronounSum;     //人称代词
    public function __construct(GetArticleComponentService $getArticleComponent, CommonService $common) {
        $this->getArticleComponent = $getArticleComponent;
        $this->requestParam = request()->all();
        $this->common = $common;
        $this->articleMmodule = $this->getArticleComponent->getAssemble();
        $this->nounSum = count($this->articleMmodule["nounList"]);
        $this->puncSum = count($this->articleMmodule["puncList"]);
        $this->modalParticleSum = count($this->articleMmodule["modalParticleList"]);
        $this->adjectiveSum = count($this->articleMmodule["adjectiveList"]);
        $this->verbSum = count($this->articleMmodule["verbList"]);
        $this->auxiliarySum = count($this->articleMmodule["auxiliaryList"]);
        $this->personalPronounSum = count($this->articleMmodule["personalPronounList"]);
    }

    /**
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function assemble() {
        if(!$this->nounSum || !$this->puncSum || !$this->modalParticleSum || !$this->adjectiveSum || !$this->verbSum || !$this->auxiliarySum || !$this->personalPronounSum) {
            return $this->common->returnJson(400,"系统异常，请联系管理员",false);
        }
        if(empty($this->requestParam["SVO"])) {
            return $this->common->returnJson(400,"缺少主语",false);
        }
        $name = $this->requestParam["SVO"];
        $article = "";
        $addNounNum = rand(3,6);                                                //添加名词次数
        $addAdjectiveNum = rand(3,6);                                           //添加形容词次数
        $addVerbNum = abs($addNounNum - $addAdjectiveNum)?:1;           //添加动词次数，至少添加一次
        $article = $this->insertmodalParticle($article);                        //插入语气词
        $article = $this->insertPunc($article);                              //插入标点
        $article .= "我的".$name;                                          //我的 name(对象名)
        $article = $this->insertPunc($article);                              //插入标点
        $article = $this->insertPersonalPronoun($article)."。。";                       //我的。。
        $article = $this->insertNoun($article);                                  //插入名词
        $article .= "般的".$name;                                                 //般的 name(对象名)
        $article = $this->insertPunc($article);                                //插入标点
        $article = $this->insertPersonalPronoun($article)."。.";                 //你。.

        for(;$addNounNum--;) {
            $article = $this->insertAuxiliary($article);
            //插入名词
            $article =  $this->insertNoun($article);
            $article = $this->insertPunc($article);
        }
        for(;$addAdjectiveNum--;) {
            $article = $this->insertAuxiliary($article);
            //插入形容词
            $article = $this->insertAdjective($article);
            $article = $this->insertPunc($article);
        }
        for(;$addVerbNum--;) {
            $article = $this->insertPersonalPronoun($article);
            //插入动词
            $article = $this->insertVerb($article);
            $article = $this->insertPunc($article);
        }
        return $this->common->returnJson(200,"生成完成",$article);
    }

    /**
     * 插入名词
     * @param $article
     * @return string
     */
    protected function insertNoun($article) {
        //随机取一个词插入
        $nounNum = rand(0,$this->nounSum - 1);
        $article .= $this->articleMmodule["nounList"][$nounNum];
        return $article;
    }

    /**
     * 插入形容词
     * @param $article
     * @return string
     */
    protected function insertAdjective($article) {
        //随机取一个词插入
        $adjectiveNum = rand(0,$this->adjectiveSum - 1);
        $article .= $this->articleMmodule["adjectiveList"][$adjectiveNum];
        return $article;
    }

    /**
     * 插入动词
     * @param $article
     * @return string
     */
    protected function insertVerb($article) {
        //随机取一个词插入
        $verbNum = rand(0,$this->verbSum - 1);
        $article .= $this->articleMmodule["verbList"][$verbNum];
        return $article;
    }
    /**
     * 插入语气词
     * @param $article
     * @return string
     */
    protected function insertmodalParticle($article) {
        //随机取一个词插入
        $modalParticleNum = rand(0,$this->modalParticleSum - 1);
        $article .= $this->articleMmodule["modalParticleList"][$modalParticleNum];
        return $article;
    }

    /**
     * 插入助词
     * @param $article
     * @return string
     */
    protected function insertAuxiliary($article) {
        //随机取一个词插入
        $auxiliaryNum = rand(0,$this->auxiliarySum - 1);
        $article .= $this->articleMmodule["auxiliaryList"][$auxiliaryNum];
        return $article;
    }


    /**
     * 插入人称代词
     * @param $article
     * @return string
     */
    protected function insertPersonalPronoun($article) {
        //随机取一个词插入
        $personalPronounNum = rand(0,$this->personalPronounSum - 1);
        $article .= $this->articleMmodule["personalPronounList"][$personalPronounNum];
        return $article;
    }


    /**
     * 插入标点
     * @param $article
     * @return string
     */
    protected function insertPunc($article) {
        //随机取一个词插入
        $puncNum = rand(0,$this->puncSum - 1);
        $article .= $this->articleMmodule["puncList"][$puncNum];
        return $article;
    }

    public function getComponentList() {
        $assemble = $this->getArticleComponent->getAssemble();
        return $assemble;
    }
}
