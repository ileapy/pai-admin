<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

/**
 * Class MiniVideoOrder
 * @package app\api\model\mini
 */
class MiniVideoOrder extends BaseModel
{
    use ModelTrait;

    /**
     * 判断是否购买
     * @param int $uid
     * @param string $vid
     * @param string $xid
     * @return bool
     */
    public static function videoIsPay(int $uid, string $vid, string $xid):bool
    {
        return self::where("uid",$uid)->where("vid",$vid)->where("xid",$xid)->value("paid") ? true : false;
    }
}