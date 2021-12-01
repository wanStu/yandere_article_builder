<?php

namespace App\Http\Services;

class common
{
    /**
     * 返回数据
     * @param $status
     * @param string $message
     * @param bool $data
     * @return false|string
     */
    public function returnJson($status,$message = "",$data = true) {
        return json_encode(["status" => $status,"message" => $message,"data" => $data],JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取csrf token
     */
    public function getCsrfTokne() {
        return $this->returnJson(200,"获取成功",csrf_token());
    }
}
