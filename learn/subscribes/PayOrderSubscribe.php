<?php


namespace learn\subscribes;

/**
 * Class PayOrderSubscribe
 * @package learn\subscribes
 */
class PayOrderSubscribe
{
    /**
     * 支付成功异步回调处理
     * @param $event
     */
    public function onPayOrderBefore($event)
    {
        list($payInfo) = $event;
        file_put_contents("payInfo.log",json_encode($payInfo));
    }
}