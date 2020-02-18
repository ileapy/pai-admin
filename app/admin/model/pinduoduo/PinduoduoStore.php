<?php


namespace app\admin\model\pinduoduo;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use think\facade\Db;

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
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getStoreId(int $aid)
    {
        return self::with("provider")->where("aid",$aid)->find();
    }

    /**
     * 关联
     * @return \think\model\relation\HasMany
     */
    public function provider()
    {
        return $this->hasMany(PinduoduoProvider::class,"id","pid");
    }
}