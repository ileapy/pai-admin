<?php


namespace app\api\controller\wechat;


use learn\services\WechatService;

/**
 * Class WechatController
 * @package app\api\controller\wechat
 */
class WechatController
{
    public function serve()
    {
        return WechatService::serve();
    }
}