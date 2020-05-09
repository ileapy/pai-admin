<?php


namespace app\api\controller\wechat;

use app\api\model\user\User;
use app\api\model\wechat\WechatUser;
use app\Request;
use learn\services\MiniProgramService;
use learn\services\pay\PayService;
use learn\services\UtilService as Util;
use learn\utils\Jwt;
use think\facade\Cache;

/**
 * 小程序
 * Class MiniProgramController
 * @package app\api\controller\wechat
 */
class MiniProgramController
{
    /**
     * 获取 openId, sessionKey, unionId
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException|\EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getOpenid(Request $request)
    {
        $where = Util::getMore([
           ['code','']
        ]);
        if ($where['code'] == "") return app("json")->fail("参数有误！code为空！");
        $data = MiniProgramService::session($where['code']);
        return empty($data) ? app("json")->fail("获取失败") : app("json")->success("ok",$data);
    }

    /**
     * @param Request $request
     * @return
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(Request $request)
    {
        $data = Util::getMore([
            ['session_key',''],
            ['iv',''],
            ['encryptedData',''],
        ]);
        if (!$data['session_key'] || !$data['iv'] || !$data['encryptedData']) return app("json")->fail("参数有误！");
        $userInfo = MiniProgramService::encryptor($data['session_key'],$data['iv'],$data['encryptedData']); // 解析用户信息
        WechatUser::setUser($userInfo); //更新或者添加用户
        $token = Jwt::signToken(User::getUserInfoByUid(WechatUser::getUidByOpenid($userInfo['openId'])));
        if (!$token) return app("json")->fail("登录失败！token生成失败！");
        Cache::store("redis")->set($userInfo['openId'],$token);
        return app("json")->success(['token'=>$token,'userInfo'=>$userInfo]);
    }

    /**
     * @param Request $request
     */
    public function notify(Request $request)
    {
        PayService::app("wechat","miniapp")->notify();
    }

    /**
     * 微信小程序支付
     * @param Request $request
     */
    public function pay(Request $request)
    {
        PayService::app("wechat","miniapp")->pay([]);
    }

    /**
     * 小程序服务
     * @return \think\Response
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function serve()
    {
        return MiniProgramService::serve();
    }
}