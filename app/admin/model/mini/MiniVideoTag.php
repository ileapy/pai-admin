<?php


namespace app\admin\model\mini;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class MiniVideoTag
 * @package app\admin\model\mini
 */
class MiniVideoTag extends BaseModel
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
        if ($where['name'] != "") $model = $model->where("name","like","%$where[name]%");
        if ($where['status'] != "") $model = $model->where("status",$where['status']);
        if ($where['type'] != "") $model = $model->where("type",$where['type']);
        $count = self::counts($model);
        $model = $model->order("rank desc, id desc");
        $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select();
        if ($data) $data = $data->toArray();
        return compact("data","count");
    }
}