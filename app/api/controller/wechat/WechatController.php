<?php


namespace app\api\controller\wechat;


use app\Request;
use learn\services\WechatService;

/**
 * Class WechatController
 * @package app\api\controller\wechat
 */
class WechatController
{
    /**
     * 微信服务
     * @return \think\Response
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \ReflectionException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function serve()
    {
        return WechatService::serve();
    }

    /**
     * 公众号支付后回调
     * @param Request $request
     */
    public function notify(Request $request)
    {
        var_dump($request->param());
        file_put_contents("pay.log",json_encode($request->param()));
    }
}