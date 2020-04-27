<?php


namespace app\admin\model\mini;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class MiniVideoItem
 * @package app\admin\model\mini
 */
class MiniVideoItem extends BaseModel
{
    use ModelTrait;

    /**
     * 剧集列表
     * @param string $vid
     * @return array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function lst(string $vid)
    {
        $model = new self;
        $model = $model->where("vid",$vid);
        $model = $model->order("name desc");
        $count = self::counts($model);
        $data = $model->select();
        if ($data) $data = $data->toArray();
        return compact("data","count");
    }
}