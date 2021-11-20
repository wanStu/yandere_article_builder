<?php

namespace App\Http\Controllers;
use App\Http\Services\Component;
use App\Http\Services\GetArticleComponent;

/**
 * 文章组装
 */
class ArticleAssembleController
{
    protected $getArticleComponent;
    public function __construct(GetArticleComponent $getArticleComponent) {
        $this->getArticleComponent = $getArticleComponent;
    }
    public function assemble() {
        $assemble = $this->getArticleComponent->getAssemble();
        return $assemble;
    }

    public function getComponentList() {
        $assemble = $this->getArticleComponent->getAssemble();
        return $assemble;
    }
}
