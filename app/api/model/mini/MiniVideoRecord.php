<?php

namespace app\api\model\mini;

use app\admin\model\ModelTrait;
use app\api\model\BaseModel;

/**
 * Class MiniVideoRecord
 * @package app\api\model\mini
 */
class MiniVideoRecord extends BaseModel
{
    use ModelTrait;

    public static function record(int $uid, string $vid, $xid = "")
    {
        $add_time = time();
        return self::insert(compact("uid","vid","xid","add_time"));
    }

    /**
     * @param string $vid
     * @param int $uid
     * @return int|mixed
     */
    public static function curNum(string $vid,int $uid)
    {
        $xid = self::where("vid",$vid)->where("uid",$uid)->order("add_time desc")->value("xid");
        return $xid ? MiniVideoItem::where("vid",$vid)->where("xid",$xid)->value("name") : 1;
    }

    /**
     * @param string $vid
     * @param int $uid
     * @return mixed|string
     */
    public static function curXid(string $vid,int $uid)
    {
        return self::where("vid",$vid)->where("uid",$uid)->order("add_time desc")->value("xid") ?: "";
    }
}