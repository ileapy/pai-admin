<?php


namespace app\admin\model\cms;

use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class CmsArticle
 * @package app\admin\model\cms
 */
class CmsArticle extends BaseModel
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
        $model = $model->with("category");
        if ($where['name']) $model = $model->where("name","like",$where['name']);
        $model = $model->append($where);
        return $model->paginate(10)->each(function ($item){
            $item['view'] = CmsRecord::where("type",1)->count();
            $item['like'] = CmsRecord::where("type",2)->count();
        });;
    }

    /**
     * 关联
     * @return \think\model\relation\HasMany
     */
    public function category()
    {
        return $this->hasOne(CmsCategory::class,"id","cid");
    }
}