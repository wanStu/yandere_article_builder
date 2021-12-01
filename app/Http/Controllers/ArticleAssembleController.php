<?php

namespace App\Http\Controllers;
use App\Http\Services\GetArticleComponentService;
use App\Http\Services\CommonService;
/**
 * 文章组装
 */
class ArticleAssembleController
{
    // 1 modal_particle 语气助词 | 2 noun 名词 | 3 adjective 形容词 | 4 predicate 谓语 | 5 punc_list 标点
    protected $getArticleComponent;
    protected $requestParam;
    protected $common;

    protected $articleMmodule;

    protected $modalParticleSum;    //语气词数量
    protected $nounSum;             //名词数量
    protected $adjectiveSum;        //形容词数量
    protected $predicateSum;        //谓语数量
    protected $puncSum;             //标点数量

    protected $auxiliarySum1;
    protected $auxiliarySum2;
    protected $me;
    protected $my;
    public function __construct(GetArticleComponentService $getArticleComponent, CommonService $common) {
        $this->getArticleComponent = $getArticleComponent;
        $this->requestParam = request()->all();
        $this->common = $common;
        $this->articleMmodule = $this->getArticleComponent->getAssemble();
        $this->modalParticleSum = count($this->articleMmodule["modalParticleList"]);
        $this->nounSum = count($this->articleMmodule["nounList"]);
        $this->adjectiveSum = count($this->articleMmodule["adjectiveList"]);
        $this->predicateSum = count($this->articleMmodule["predicateList"]);
        $this->puncSum = count($this->articleMmodule["puncList"]);

        $this->articleMmodule["auxiliaryList1"] = ["是","是","你是"];
        $this->auxiliarySum1 = count($this->articleMmodule["auxiliaryList1"]);

        $this->articleMmodule["auxiliaryList2"] = ["那么","那么","那么","又","又","又","意想不到的"];
        $this->auxiliarySum2 = count($this->articleMmodule["auxiliaryList2"]);

        $this->me = "我";
        $this->my = "我的";

    }

    /**
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function assemble() {
        if(!$this->modalParticleSum || !$this->nounSum || !$this->adjectiveSum || !$this->predicateSum || !$this->puncSum) {
            return $this->common->returnJson(400,"系统异常，请联系管理员",false);
        }
        if(empty($this->requestParam["SVO"])) {
            return $this->common->returnJson(400,"缺少主语",false);
        }
        $name = $this->requestParam["SVO"];
        $article = "";
        //插入语气词
        $article = $this->insertmodalParticle($article);
        //插入标点
        $article = $this->insertPunc($article);
        //我的 name(对象名)
        $article .= $this->my.$name;
        //插入标点
        $article = $this->insertPunc($article);
        //我的
        $article .= $this->my;
        //插入名词
        $article = $this->insertNoun($article);
        //般的 name(对象名)
        $article .= "般的".$name;
        //插入标点
        $article = $this->insertPunc($article);
        //name(对象名)
        $article .= $name;
        //插入标点
        $article = $this->insertPunc($article);
        //插入名词
        for($i = rand(3,6);$i--;) {
            //是|你是
            $article = $this->insertAuxiliary($article,1);
            //插入名词
            $article =  $this->insertNoun($article);
            $article = $this->insertPunc($article);
        }
        //name(对象名)
        $article .= $name;
        //插入标点
        $article = $this->insertPunc($article);
        //再次插入名词
        for($i = rand(3,6);$i--;) {
            //是|你是
            $article = $this->insertAuxiliary($article,1);
            //插入名词
            $article =  $this->insertNoun($article);
            $article = $this->insertPunc($article);
        }
        //插入形容词
        for($i = rand(3,6);$i--;) {
            //那么|又|意想不到的
            $article = $this->insertAuxiliary($article,2);
            //插入形容词
            $article = $this->insertAdjective($article);
            $article = $this->insertPunc($article);
        }
        for($i = rand(3,6);$i--;) {
            //我
            $article .= $this->me;
            //插入谓语
            $article = $this->insertPredicate($article);
            $article = $this->insertPunc($article);
        }
        //name(对象名)
        $article .= $name;
        //插入标点
        $article = $this->insertPunc($article);
        return $this->common->returnJson(200,$name,$article);
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

    /**
     * 插入助词
     * @param $article
     * @return string
     */
    protected function insertAuxiliary($article,$type) {
        //随机取一个词插入
        if(1 == $type) {
            $auxiliaryNum = rand(0,$this->auxiliarySum1 - 1);
            $article .= $this->articleMmodule["auxiliaryList1"][$auxiliaryNum];
        }else if(2 == $type) {
            $auxiliaryNum = rand(0,$this->auxiliarySum2 - 1);
            $article .= $this->articleMmodule["auxiliaryList2"][$auxiliaryNum];
        }
        return $article;
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
     * 插入谓语
     * @param $article
     * @return string
     */
    protected function insertPredicate($article) {
        //随机取一个词插入
        $predicateNum = rand(0,$this->predicateSum - 1);
        $article .= $this->articleMmodule["predicateList"][$predicateNum];
        return $article;
    }

    public function getComponentList() {
        $assemble = $this->getArticleComponent->getAssemble();
        return $assemble;
    }
}



