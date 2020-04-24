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

    protected $pk = "cid";

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
        $model = $model->withJoin("category");
        if ($where['name'] != "") $model = $model->where("category.name","like","%$where[name]%");
        if ($where['status'] != "") $model = $model->where("cms_page.status",$where['status']);
        $model = $model->append($where);
        return $model->paginate(10);
    }

    /**
     * 关联
     * @return \think\model\relation\HasOne
     */
    public function category()
    {
        return $this->hasOne(CmsCategory::class,"id","cid");
    }
}