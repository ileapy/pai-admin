<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use learn\services\WechatService;

/**
 * 微信用户
 * Class WechatUser
 * @package app\admin\model\wechat
 */
class WechatUser extends BaseModel
{
    use ModelTrait;

    /**
     * 订阅
     * @param string $openId
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function subscribe(string $openId)
    {
        if (self::be($openId,'openid'))
        {

        }else
        {
            $userInfo = WechatService::getUserInfo($openId);
            file_put_contents("user.log",json_encode($userInfo));
        }

    }

    /**
     * 取消订阅
     * @param string $openId
     */
    public static function unSubscribe(string $openId)
    {

    }
}