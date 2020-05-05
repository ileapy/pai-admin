<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

/**
 * Class MiniVideoItem
 * @package app\api\model\mini
 */
class MiniVideoItem extends BaseModel
{
    use ModelTrait;

    /**
     * 获取电视剧列表
     * @param string $vid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getListByVid(string $vid)
    {
        $model = new self;
        $model = $model->where("vid",$vid);
        $model = $model->where("status",1);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }
}