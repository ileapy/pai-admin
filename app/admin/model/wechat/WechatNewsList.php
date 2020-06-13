<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * 图文列表
 * Class WechatNewsList
 * @package app\admin\model\wechat
 */
class WechatNewsList extends BaseModel
{
    use ModelTrait;

    /**
     * 图文列表
     * @param array $where
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public static function system(array $where)
    {
        $model = new self;
        return $model->paginate($where['limit'])->each(function ($item){
            $item['cover'] = WechatNews::get(explode(",",$item['item'])[0]);
        })->appends($where);
    }

    /**
     * 获取图文子数据
     * @param int $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getAllItem(int $id)
    {
        $item = self::where("id",$id)->value("item");
        $model = WechatNews::where("id","in",explode(",",$item));
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }
}