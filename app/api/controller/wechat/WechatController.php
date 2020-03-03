<?php


namespace app\api\controller\wechat;


class WechatController
{
    public function serve()
    {
        return WechatService::serve();
    }
}