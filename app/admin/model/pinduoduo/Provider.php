<?php


namespace app\admin\model\pinduoduo;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

class Provider extends BaseModel
{
    use ModelTrait;

    /**
     * 列表
     * @param array $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage(array $where): array
    {
        $model = new self;
        if ($where['app_name'] != '') $model = $model->where("app_name|id","like","%$where[app_name]%");
        if ($where['status'] != '') $model = $model->where("status",$where['status']);
        if ($where['developer_id'] != '') $model = $model->where("developer_id",$where['developer_id']);
        if ($where['page'] && $where['limit']) $model = $model->page((int)$where['page'],(int)$where['limit']);
        $count = self::count($model);
        $data = $model->select();
        $data = $data ? $data->toArray() : [];
        return compact("data","count");
    }

    /**
     * 数据量
     * @param string|\think\db\Raw $model
     * @return int
     */
    public static function count($model): int
    {
        return $model->count();
    }
}