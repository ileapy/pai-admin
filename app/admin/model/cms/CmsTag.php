<?php


namespace app\admin\model\cms;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

class CmsTag extends BaseModel
{
    use ModelTrait;

    /**
     * 列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function lst()
    {
        $model = new self;
        $model = $model->where("status",1);
        $model = $model->field("id,name");
        $model = $model->order("rank desc");
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }

    /**
     * 分页
     * @param $where
     * @return array
     */
    public static function systemPage($where)
    {
        $model = new self;
        if ($where['name'] != '') $model = $model->where("name","like","%$where[name]%");
        if ($where['status'] != '') $model = $model->where("status",$where['status']);
        $count = self::counts($model);
        $model = $model->page($where['page'],$where['limit']);
        $data = $model->select();
        if ($data) $data = $data->toArray();
        return compact("data","count");
    }
}