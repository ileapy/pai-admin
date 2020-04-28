<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

/**
 * 小程序轮播
 * Class MiniVideoBanner
 * @package app\api\model\mini
 */
class MiniVideoBanner extends BaseModel
{
    use ModelTrait;

    protected $hidden = ['create_time','create_user','update_time','update_user','status','rank'];
    /**
     * 获取轮播
     * @param int $num
     * @return array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function lst(int $num)
    {
        $data = self::where("status",1)
            ->order("rank desc")
            ->order("id desc")
            ->limit($num)
            ->select();
        if ($data) $data = $data->toArray();
        return $data ?: [];
    }
}