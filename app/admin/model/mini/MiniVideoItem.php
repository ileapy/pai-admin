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
     * @param array $where
     * @return array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage(array $where)
    {
        $model = new self;
        $model = $model->where("vid",$where['vid']);
        if ($where['name'] != "") $model = $model->where("name|xid","like","%$where[name]%");
        if ($where['status'] != "") $model = $model->where("status",$where['status']);
        $count = self::counts($model);
        $model = $model->order("create_time desc");
        $model = $model->order("rank desc");
        $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select();
        if ($data) $data = $data->toArray();
        return compact("data","count");
    }
}