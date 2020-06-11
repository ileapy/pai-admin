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
}