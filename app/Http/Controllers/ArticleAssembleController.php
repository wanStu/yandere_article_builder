<?php

namespace App\Http\Controllers;
use App\Http\Services\GetArticleComponent;
use App\Http\Services\common;
/**
 * 文章组装
 */
class ArticleAssembleController
{
    protected $getArticleComponent;
    protected $requestParam;
    protected $common;
    protected $articleMmodule;
    protected $nounNum;             //名词数量
    protected $puncNum;             //标点数量
    protected $modalParticleNum;    //语气词数量
    protected $adjectiveNum;        //形容词数量
    protected $verbNum;             //名词数量
    public function __construct(GetArticleComponent $getArticleComponent,common $common) {
        $this->getArticleComponent = $getArticleComponent;
        $this->requestParam = request()->all();
        $this->common = $common;
        $this->articleMmodule = $this->getArticleComponent->getAssemble();
        $this->articleMmodule["is"] = [
            "是","是","你是","我是"
        ];
        $this->articleMmodule["personal_pronoun"] = [
            "I" => "我", "my" => "我的", "you" => "你","your" => "你的"
        ];
        $this->nounNum = rand(0,count($this->articleMmodule["nounList"]) - 1);
        $this->puncNum = rand(0,count($this->articleMmodule["puncList"]) - 1);
        $this->modalParticleNum = rand(0,count($this->articleMmodule["modalParticleList"]) - 1);
        $this->adjectiveNum = rand(0,count($this->articleMmodule["adjectiveList"]) - 1);
        $this->verbNum = rand(0,count($this->articleMmodule["verbList"]) - 1);
    }

    /**
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function assemble() {
        if(empty($this->requestParam["SVO"])) {
            return $this->common->returnJson(400,"缺少主语",false);
        }
        $name = $this->requestParam["SVO"];
        $article = "";
        $addNounNum = rand(3,6);                                            //添加名词次数
        $addAdjectiveNum = rand(3,6);                                       //添加形容词次数
        $addVerbNum = abs($addNounNum - $addAdjectiveNum)?:1;       //添加动词次数，至少添加一次
        $article = $this->insertmodalParticle($article);                          //插入语气词
        $article = $this-$this->puncNum($article);                                //插入标点
        $article .= $this->articleMmodule["personal_pronoun"]["my"].$name;                      //我的 name(对象名)
        $article = $this-$this->puncNum($article);                                //插入标点
        $article .= $this->articleMmodule["personal_pronoun"]["my"];                            //我的
        $article = $this->insertNoun($article);                                   //插入名词
        $article .= "般的".$name;                                                 //般的 name(对象名)
        $article = $this-$this->puncNum($article);                                //插入标点
        $article .= $this->articleMmodule["personal_pronoun"]["you"]."。.";        //你。.
        for(;$addNounNum--;) {
            //插入名词
            $article =  $this->insertNoun($article);
        }
        for(;$addAdjectiveNum--;) {
            //插入形容词
            $article = $this->insertAdjective($article);
        }
        for(;$addVerbNum--;) {
            //插入动词
            $article = $this->insertVerb($article);
        }
        return view("article",compact("name","article"));
    }

    /**
     * 插入名词
     * @param $article
     * @return string
     */
    protected function insertNoun($article) {
        //随机取一个词插入
        $article .= $this->articleMmodule["nounList"][rand(0,$this->nounNum)];
        return $article;
    }

    /**
     * 插入形容词
     * @param $article
     * @return string
     */
    protected function insertAdjective($article) {
        //随机取一个词插入
        $article .= $this->articleMmodule["adjectiveList"][rand(0,$this->adjectiveNum)];
        return $article;
    }

    /**
     * 插入动词
     * @param $article
     * @return string
     */
    protected function insertVerb($article) {
        //随机取一个词插入
        $article .= $this->articleMmodule["verbList"][rand(0,$this->verbNum)];
        return $article;
    }
    /**
     * 插入语气词
     * @param $article
     * @return string
     */
    protected function insertmodalParticle($article) {
        //随机取一个词插入
        $article .= $this->articleMmodule["modalParticleList"][rand(0,$this->modalParticleNum)];
        return $article;
    }
    /**
     * 插入标点
     * @param $article
     * @return string
     */
    protected function insertPunc($article) {
        //随机取一个词插入
        $article .= $this->articleMmodule["puncList"][rand(0,$this->puncNum)];
        return $article;
    }

    public function getComponentList() {
        $assemble = $this->getArticleComponent->getAssemble();
        return $assemble;
    }
}
