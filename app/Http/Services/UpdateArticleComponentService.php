<?php

namespace App\Http\Services;

use App\Models\ComponentModel;


/**
 * 上传文章组件
 */
class UpdateArticleComponentService
{
    protected $requestData;
    public function __construct() {
        $this->requestData = request()->all();
    }


    /**
     * 插入新词
     * @param $type string 类型
     * @param $contentArr array 词数组
     * @return string
     */
    public function insert($type,$contentArr)
    {
        $model = new ComponentModel();
        $repetitionField = $model->where("type",$type)->where("is_delete",0)->whereIn("content",$contentArr)->pluck("content")->toArray();
        $data = [];
        foreach ($contentArr as $value) {
//            不录入重复的值
//            if(in_array($value,(array)$repetitionField)) {
//                continue;
//            }
            $data[] = [
                "type"          => $type,
                "content"       => $value,
                "create_time"   => time(),
                "update_time"   => time()
            ];
        }
        unset($value);
        $insertResult = $model->insert($data);
        return $insertResult;
    }

    /**
     * 删除词
     * @param string $type
     * @param array $idAttr
     * @throws \Exception
     */
    public function delete(string $type, array $idAttr) {
        $model = new ComponentModel();
        $deleteResult = $model->where("type",$type)->where("is_delete",0)->whereIn("id",$idAttr)->update(["is_delete" => 1,"delete_time" => time()]);
        if($deleteResult) {
            return true;
        }else {
            return false;
        }
    }
}
