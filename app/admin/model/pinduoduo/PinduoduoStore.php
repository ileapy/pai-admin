<?php


namespace app\admin\model\pinduoduo;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * 店铺
 * Class PinduoduoStore
 * @package app\admin\model\pinduoduo
 */
class PinduoduoStore extends BaseModel
{
    use ModelTrait;

    /**
     * 获取店铺信息
     * @param $aid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function info($aid)
    {
        $model = new self;
        $model = $model->where("aid",$aid);
        $info = $model->find();
        return $info ? $info->toArray() : [];
    }
}