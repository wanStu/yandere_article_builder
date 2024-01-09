<?php

namespace App\Http\Controllers;

use App\Http\Services\CommonService;

class TestRequestController
{
    protected $common;
    public function __construct(CommonService $common) {
        $this->common = $common;
    }
    

    public function testSortArray() {
        $this->common->sortArrayUseKey([
            [
                'a' => 2
            ],
            [
                'a' => 1
            ],
            [
                'a' => 3
            ]
        ], 'a');
    }
}



