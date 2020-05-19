<?php


namespace app\api\model\user;


use app\api\model\BaseModel;
use app\api\model\mini\MiniVideoOrder;
use app\api\model\ModelTrait;

/**
 * Class UserOrder
 * @package app\api\model\user
 */
class UserOrder extends BaseModel
{
    use ModelTrait;

    /**
     * 订单支付成功之后
     * @param string $oid
     * @return bool
     */
    public static function orderSuccess(string $oid)
    {
        self::startTrans();
        try {
            if (!$oid) return false;
            $order = self::where("oid",$oid)->find();
            if (!$order) return false;
            self::where("oid",$oid)->update(['pay_time'=>time(),'paid'=>1,'status'=>1]);
            switch ($order['source'])
            {
                case 1: // 视频小程序订单
                    MiniVideoOrder::orderPayOver($oid);
                    break;
            }
            self::commit();
        }catch (\Exception $e)
        {
            var_dump($e->getMessage());
            self::rollback();
        }
    }
}