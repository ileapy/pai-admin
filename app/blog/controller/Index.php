<?php
namespace app\blog\controller;

use app\api\model\mini\MiniVideo;
use app\api\model\mini\MiniVideoBanner;
use app\Request;
use learn\services\WechatService;

/**
 * Class Index
 * @package app\index\controller
 */
class Index
{
    /**
     * 获取code
     * @param Request $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function code(Request $request)
    {
        $uri = urlencode($request->domain() . "/Wechat/login");
        $appid = systemConfig("wechat_appid");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$uri}&response_type=code&scope=snsapi_base&state=200&connect_redirect=1#wechat_redirect";
        header("Location:" . $url);
        exit;
    }
}
