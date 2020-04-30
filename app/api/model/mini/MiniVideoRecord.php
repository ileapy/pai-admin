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
}