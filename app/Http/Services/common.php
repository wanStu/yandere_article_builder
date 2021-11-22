<?php

namespace App\Http\Services;

class common
{
    public function returnJson($status,$message = "",$data = true) {
        return json_encode(["status" => $status,"message" => $message,"data" => $data],JSON_UNESCAPED_UNICODE);
    }
}
