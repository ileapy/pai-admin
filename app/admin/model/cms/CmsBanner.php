<?php


namespace app\admin\model\cms;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

class CmsBanner extends BaseModel
{
    use ModelTrait;

    /**
     * 分页
     * @param $where
     * @return array
     */
    public static function systemPage($where)
    {
        $model = new self;
        if ($where['name'] != '') $model = $model->where("name","like","%$where[name]%");
        if ($where['status'] != '') $model = $model->where("status",$where['status']);
        $count = self::counts($model);
        $model = $model->page($where['page'],$where['limit']);
        $data = $model->select();
        if($data) $data = $data->toArray();
        return compact("data","count");
    }
}