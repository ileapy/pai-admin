<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use app\admin\model\user\User;
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
     * @return User|WechatUser|\think\Model
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function subscribe(string $openId)
    {
        $userInfo = WechatService::getUserInfo($openId);
        $data = [
            'openid' => $userInfo['openid'],
            'nickname' => $userInfo['nickname'],
            'avatar' => $userInfo['headimgurl'],
            'sex' => $userInfo['sex'],
            'city' => $userInfo['city'],
            'language' => $userInfo['language'],
            'province' => $userInfo['province'],
            'country' => $userInfo['country'],
            'subscribe' => $userInfo['subscribe'],
            'subscribe_time' => $userInfo['subscribe_time'],
            'groupid' => $userInfo['groupid'],
            'tagid_list' => $userInfo['tagid_list'],
        ];
        return self::be($openId,"openid") ? self::updateUser($data) : self::addUser($data, User::addUser($data));
    }

    /**
     * 添加微信用户
     * @param array $data
     * @param int|string $uid
     * @return WechatUser|\think\Model
     */
    public static function addUser(array $data, int $uid)
    {
        try {
            $data['uid'] = $uid;
            file_put_contents("add.log",json_decode($data));
            return self::create($data);
        }catch (\Exception $e)
        {
            file_put_contents("error.log",$e);
        }
    }

    /**
     * 更新微信用户
     * @param array $data
     * @return User
     */
    public static function updateUser(array $data)
    {
        $uid = self::where("openid",$data['openid'])->field(['uid']);
        self::update($data,['uid'=>$uid]);
        return User::updateUser($data, (int)$uid,1);
    }

    /**
     * 取消订阅
     * @param string $openId
     * @return WechatUser
     */
    public static function unSubscribe(string $openId)
    {
        return self::update(['subscribe'=>0],['openid'=>$openId]);
    }
}