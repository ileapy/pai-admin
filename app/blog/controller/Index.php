<?php
namespace app\blog\controller;

use app\api\model\mini\MiniVideo;
use app\api\model\mini\MiniVideoBanner;
use app\blog\model\user\User;
use app\blog\model\wechat\WechatUser;
use app\Request;
use EasyWeChat\Kernel\Messages\Location;
use learn\services\UtilService as Util;
use learn\services\WechatService;
use learn\utils\Jwt;
use think\facade\Cache;

/**
 * Class Index
 * @package app\index\controller
 */
class Index
{
    /**
     * 获取code
     * @param Request $request
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function code(Request $request)
    {
        WechatService::oauthService()->scopes(['snsapi_userinfo'])
            ->redirect($request->domain() . "/blog/auth/auth")->send();
    }

    /**
     * 获取code
     * @param Request $request
     * @return
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function auth(Request $request)
    {
        $user = WechatService::oauthService()->user();
        // 更新用户信息
        WechatUser::subscribe($user->getOriginal());
        // 生成token
        $token = Jwt::signToken(User::getUserInfoByUid(WechatUser::getUidByOpenid($user->getId())));
        if (!$token) return app("json")->fail("登录失败！token生成失败！");
        Cache::store("redis")->set($user->getId(),$token);
        $url = "http://m.blog.leapy.cn/author?token=".$token;
        exit(header("location:$url"));
    }
}
