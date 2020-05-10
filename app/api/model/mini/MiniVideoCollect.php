<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

/**
 * 视频收藏
 * Class MiniVideoCollect
 * @package app\api\model\mini
 */
class MiniVideoCollect extends BaseModel
{
    use ModelTrait;

    /**
     * 收藏或者取消收藏
     * @param int $uid
     * @param string $vid
     * @return bool|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function UnAndOncollect(int $uid, string $vid)
    {
        return self::isCollect($uid,$vid) ? self::where("uid",$uid)->where("vid",$vid)->delete() : self::insert(['uid'=>$uid,'vid'=>$vid,'add_time'=>time()]);
    }

    /**
     * 是否收藏
     * @param int $uid
     * @param string $vid
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function isCollect(int $uid, string $vid): bool
    {
        return self::where("uid",$uid)->where("vid",$vid)->find() ? true : false;
    }

    /**
     * @param int $uid
     * @param array $where
     * @return array
     */
    public static function lst(int $uid,array $where)
    {
        $model = new self();
        $model = $model->where("uid",$uid);
        $model = $model->order("add_time desc");
        $model = $model->group('vid');
        $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select()->each(function ($item){
            $item['info'] = MiniVideo::get(['vid'=>$item['vid']]);
        });
        return $data ? $data->toArray() : [];
    }
}