<?php

namespace App\Http\Services;

class JsonWebToken
{
    const TOKEN_SALT = "#2021_";


    /**
     * 获取token
     */
    public function getToken() {
        $token = request()->header("Access-Token");
        if(empty($token)) {
            $token = request()->get("token");
        }
        if(empty($token)) {
            return false;
        }
        return $token;
    }
    /**
     * 销毁 cache 中的 token
     */
    public function delToken() {
        $token = $this->getToken();


    }
    /**
     * 根据 userid 生成 token
     * @param $userid
     * @return string
     */
    public function makeToken($userid) {
        $guid =$this->getGuid();
        $timeStamp = microtime(true);
        $salt = self::TOKEN_SALT;
        $token = md5("{$timeStamp}_{$userid}_{$guid}_{$salt}");
        return $token;
    }

    /**
     * 获取一个唯一的guid
     * @param bool $trim
     * @return string
     */
    public function getGuid($trim = true) {
        mt_srand(intval((double)microtime() * 10000));
        $charid = strtolower(md5(uniqid((string)rand(), true)));
        $hyphen = "-";
        $lbrace = $trim ? "" : "{";
        $rbrace = $trim ? "" : "}";
        return $lbrace .
            substr($charid, 0, 8) . $hyphen .
            substr($charid, 8, 4) . $hyphen .
            substr($charid, 12, 4) . $hyphen .
            substr($charid, 16, 4) . $hyphen .
            substr($charid, 20, 12) .
            $rbrace;
    }
}
