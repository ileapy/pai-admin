<?php


namespace app\blog\model\wechat;


use app\blog\model\BaseModel;
use app\blog\model\ModelTrait;
use app\blog\model\user\User;

/**
 * Class WechatUser
 * @package app\blog\model\wechat
 */
class WechatUser extends BaseModel
{
    use ModelTrait;
    /**
     * 使用
     * @param array $userInfo
     * @return bool
     */
    public static function subscribe(array $userInfo)
    {
        $data = [
            'openid' => $userInfo['openid'],
            'nickname' => $userInfo['nickname'],
            'avatar' => $userInfo['headimgurl'],
            'sex' => $userInfo['sex'],
            'city' => $userInfo['city'],
            'language' => $userInfo['language'],
            'province' => $userInfo['province'],
            'country' => $userInfo['country']
        ];
        return self::be($userInfo['openid'],"openid") ? self::updateUser($data) : self::addUser($data, User::addUser($data));
    }

    /**
     * 添加微信用户
     * @param array $data
     * @param int|string $uid
     * @return bool
     */
    public static function addUser(array $data, int $uid)
    {
        $data['uid'] = $uid;
        return self::create($data) ? true : false;
    }

    /**
     * 更新微信用户
     * @param array $data
     * @return bool
     */
    public static function updateUser(array $data)
    {
        $uid = self::where("openid",$data['openid'])->column('uid');
        $res1 = self::update($data,['uid'=>$uid]);
        $res2 = User::updateUser($data, (int)$uid,1);
        return $res1 && $res2;
    }

    /**
     * 通过uid 获取openid
     * @param int $uid
     * @return int|mixed
     */
    public static function getOpenidByUid(int $uid)
    {
        return self::where("uid",$uid)->value("openid") ?: 0;
    }

    /**
     * @param string $openid
     * @return int|mixed
     */
    public static function getUidByOpenid(string $openid)
    {
        return self::where("openid",$openid)->value("uid") ?: 0;
    }
}