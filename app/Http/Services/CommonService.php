<?php

namespace App\Http\Services;

class CommonService
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

    /**
     * 检查传入的数据中是否缺失 必填参数
     * @param array $data 传入的数据
     * @param array $requireParam 必填参数
     *   如 ["type","userid","sendid","title","content"]
     * @return array|false
     */
    function getMissParam($data,$requireParam) {
        $missParam = [];
        array_walk($requireParam,function ($value,$key) use ($data,&$missParam){
            if("" == $data[$value]) {
                $missParam[] = $value;
            }
        });
        if([] == $missParam) {
            return false;
        }else {
            return $missParam;
        }
    }
}
