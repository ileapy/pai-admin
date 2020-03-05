<?php


namespace app\admin\model\cms;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class CmsCategory
 * @package app\admin\model\cms
 */
class CmsCategory extends BaseModel
{
    use ModelTrait;

    /**
     * 列表
     * @param $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage($where)
    {
        $model = new self;
        if ($where['name']) $model = $model->where("name","like", $where['name']);
        if ($where['status']) $model = $model->where("status", $where['status']);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }
}