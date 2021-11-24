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
        $articleMmodule["you"] = [
            "是","是","你是"
        ];
        $articleMmodule["me"] = [
            "I" => "我", "my" => "我的"
        ];
        $adjectiveSum = count($articleMmodule["adjectiveList"]);//形容词 16
        $modalParticleSum = count($articleMmodule["modalParticleList"]);//语气词 8
        $nounSum = count($articleMmodule["nounList"]);//名词 36
        $verbSum = count($articleMmodule["verbList"]);//动词 36
        $puncSum = count($articleMmodule["puncList"]);//标点 7
        $youSum = count($articleMmodule["you"]);//人称代词 3
        $addNumOne = rand(3,6);                 //添加次数
        $addNumTwo = rand(3,6);
        $addNumThree = abs($addNumOne - $addNumTwo)?:1;
        $nounNum = rand(0,$nounSum - 1);
        $puncNum = rand(0,$puncSum - 1);
        $article .= $articleMmodule["modalParticleList"][rand(0,$modalParticleSum - 1)]             //语气词
            .$articleMmodule["puncList"][rand(0,$puncNum)]
            .$articleMmodule["me"]["my"].$name                                                 //我的 name(对象名)
            .$articleMmodule["puncList"][rand(0,$puncNum)]
            .$articleMmodule["me"]["my"].$articleMmodule["nounList"][rand(0,$nounNum)]."般的".$name //我的 noun(名词) 般的  name(对象名)
            .$articleMmodule["puncList"][rand(0,$puncNum)];
        for(;$addNumOne--;) {
            $nounNum = rand(0,$nounSum - 1);
            $puncNum = rand(0,$puncSum - 1);
            $youNum = rand(0,$youSum - 1);
            $article .= $articleMmodule["you"][$youNum].$articleMmodule["nounList"][rand(0,$nounNum)]; // you（是，你是） noun(名词)
            $article .= $articleMmodule["puncList"][rand(0,$puncNum)];
            $article .= $articleMmodule["puncList"][rand(0,$puncNum)];
        }
         $article .= $articleMmodule["puncList"][rand(0,$puncNum)];
        for(;$addNumTwo--;) {
            $youNum = rand(0,$youSum - 1);
            $puncNum = rand(0,$puncSum - 1);
            $adjectiveNum = rand(0,$adjectiveSum -1);
            $article .= $articleMmodule["you"][$youNum];
            $article .= $articleMmodule["adjectiveList"][rand(0,$adjectiveNum)]; //  adjective(形容词)
            $article .= $articleMmodule["puncList"][rand(0,$puncNum)];
        }
         $article .= $articleMmodule["puncList"][rand(0,$puncNum)];
        for(;$addNumThree--;) {
            $puncNum = rand(0,$puncSum - 1);
            $verbNum = rand(0,$verbSum - 1);
            $article .= $articleMmodule["me"]["I"].$articleMmodule["verbList"][rand(0,$verbNum)]; //  我 verb(动词)
            $article .= $articleMmodule["puncList"][rand(0,$puncNum)];
        }
         $article .= $articleMmodule["puncList"][rand(0,$puncNum)].$articleMmodule["nounList"][rand(0,$nounNum)];
        return view("article",compact("name","article"));
    }

    public function getComponentList() {
        $assemble = $this->getArticleComponent->getAssemble();
        return $assemble;
    }
}
