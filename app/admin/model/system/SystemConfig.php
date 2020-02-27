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
    public static function lst($where): array
    {
        $model = new self;
        if ($where['tab_id']) $model = $model->where('tab_id',$where['tab_id']);
        $count = self::counts($model);
        if ($where['page'] && $where['limit']) $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select();
        return compact('data','count');
    }
}