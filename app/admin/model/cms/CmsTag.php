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
}