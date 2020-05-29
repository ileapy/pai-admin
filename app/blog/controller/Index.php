<?php
namespace app\blog\controller;

use app\api\model\mini\MiniVideo;
use app\api\model\mini\MiniVideoBanner;
use app\blog\model\wechat\WechatUser;
use app\Request;
use learn\services\UtilService as Util;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
    }
}
