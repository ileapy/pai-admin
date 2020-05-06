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
            return self::where("uid",$uid)->where("vid",$vid)->where("xid",$xid)->update(['sec'=>$sec]);
        }else
        {
            return self::insert(compact("uid","vid","xid","sec"));
        }
    }
}