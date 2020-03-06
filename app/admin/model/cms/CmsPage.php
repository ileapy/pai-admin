<?php


namespace app\admin\model\cms;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class CmsPage
 * @package app\admin\model\cms
 */
class CmsPage extends BaseModel
{
    use ModelTrait;

    /**
     * @param array $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage(array $where)
    {
        $model = new self;
        if ($where['name']) $model = $model->where("name","like",$where['name']);
        $model = $model->append($where);
        return $model->paginate(10);
    }
}