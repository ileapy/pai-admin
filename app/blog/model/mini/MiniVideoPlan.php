<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

/**
 * Class MiniVideoPlan
 * @package app\api\model\mini
 */
class MiniVideoPlan extends BaseModel
{
    use ModelTrait;

    /**
     * @param int $uid
     * @param string $vid
     * @param string $xid
     * @param Float $sec
     * @return MiniVideoPlan|int|string
     */
    public static function pause(int $uid, string $vid ,string $xid, Float $sec)
    {
        if (self::where("uid",$uid)->where("vid",$vid)->where("xid",$xid)->count() > 0)
        {
            return self::where("uid",$uid)->where("vid",$vid)->where("xid",$xid)->update(['sec'=>$sec,'update_time'=>time()]);
        }else
        {
            $update_time = time();
            return self::insert(compact("uid","vid","xid","sec","update_time"));
        }
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
        $model = $model->order("update_time desc");
        $model = $model->group('vid');
        $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select()->each(function ($item){
            $item['info'] = MiniVideo::get(['vid'=>$item['vid']]);
        });
        return $data ? $data->toArray() : [];
    }
}