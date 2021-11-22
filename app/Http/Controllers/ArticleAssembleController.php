<?php

namespace App\Http\Controllers;
use App\Http\Services\Component;
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
    public function __construct(GetArticleComponent $getArticleComponent,common $common) {
        $this->getArticleComponent = $getArticleComponent;
        $this->requestParam = request()->all();
        $this->common = $common;
    }
    public function assemble() {
        if(empty($this->requestParam["SVO"])) {
            return $this->common->returnJson(400,"缺少主语",false);
        }
        $name = $this->requestParam["SVO"];
        $article = "";
        $articleMmodule = $this->getArticleComponent->getAssemble();
        $articleMmodule["personal_pronoun"] = [
            "你","我","他","她","它"
        ];
        $adjectiveSum = count($articleMmodule["adjectiveList"]);//形容词
        $modalParticleSum = count($articleMmodule["modalParticleList"]);//语气词
        $nounSum = count($articleMmodule["nounList"]);//名词
        $verbSum = count($articleMmodule["verbList"]);//动词
        $puncSum = count($articleMmodule["puncList"]);//标点
        $personalPronounSum = count($articleMmodule["personal_pronoun"]);//人称代词
        for (;strlen($article) <= 1000;) {
            $adjectiveNum = rand(0,$adjectiveSum - 1);
            $modalParticleNum = rand(0,$modalParticleSum - 1);
            $nounNum = rand(0,$nounSum - 1);
            $verbNum = rand(0,$verbSum - 1);
            $puncNum = rand(0,$puncSum - 1);
            $personalPronounNum = rand(0,$personalPronounSum - 1);
            $article .=
                $articleMmodule["modalParticleList"][$modalParticleNum]
                .$name
                .$articleMmodule["personal_pronoun"][$personalPronounNum]."是"
                .$articleMmodule["personal_pronoun"][$personalPronounNum]."的"
                .$articleMmodule["adjectiveList"][$adjectiveNum]
                .$articleMmodule["puncList"][$puncNum]."是"
                .$articleMmodule["personal_pronoun"][$personalPronounNum]."的"
                .$articleMmodule["nounList"][$nounNum]
                .$articleMmodule["puncList"][$puncNum]
                .$articleMmodule["personal_pronoun"][$personalPronounNum]
                .$articleMmodule["puncList"][$puncNum]
                .$articleMmodule["verbList"][$verbNum]
                .$articleMmodule["puncList"][$puncNum];
        }
        return view("article",compact("name","article"));
//        return $this->common->returnJson(200,"生成完毕",$article);
    }

    public function getComponentList() {
        $assemble = $this->getArticleComponent->getAssemble();
        return $assemble;
    }
}
