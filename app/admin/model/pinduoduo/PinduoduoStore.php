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

    /**
     * 是否绑定店铺
     * @param $aid
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function isBingInfo(int $aid)
    {
        return self::where("aid",$aid)->find();
    }

    /**
     * 获取店铺绑定的供应商信息
     * @param int $aid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getClientByAid(int $aid):array
    {
        $model = new self;
        $model = $model->alias("s");
        $model = $model->where("s.aid",$aid);
        $model = $model->withJoin("__pinduoduo_provider__ p","s.pid= p.id");
        $data = $model->find();
        return $data ? $data->toArray() : [];
    }
}