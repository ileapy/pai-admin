<?php


namespace app\admin\model\system;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * 系统配置
 * Class SystemConfig
 * @package app\admin\model\system
 */
class SystemConfig extends BaseModel
{
    use ModelTrait;

    /**
     * 列表
     * @param int $tab_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function lst(int $tab_id=0): array
    {
        $model = new self;
        $model = $model->where('tab_id',$tab_id);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }
}