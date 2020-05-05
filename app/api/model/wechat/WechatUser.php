<?php


namespace app\api\model\wechat;


use app\admin\model\BaseModel;
use app\api\model\ModelTrait;
use app\api\model\user\User;

/**
 * Class WechatUser
 * @package app\api\model\wechat
 */
class WechatUser extends BaseModel
{
    use ModelTrait;

    /**
     * 更新或添加文件
     * @param $userInfo
     * @return bool|void|null
     */
    public static function setUser(array $userInfo)
    {
//        return (self::be($userInfo["openId"],"openid") ? self::updateUser($userInfo) : self::addUser($userInfo)) ? self::commitTrans() : self::rollbackTrans();
        self::startTrans();
        try {
            return (self::be($userInfo["openId"],"openid") ? self::updateUser($userInfo) : self::addUser($userInfo)) ? self::commitTrans() : self::rollbackTrans();
        }catch (\Exception $e)
        {
            self::rollbackTrans();
        }
    }

    /**
     * 添加用户
     * @param array $userInfo
     * @return bool
     */
    public static function addUser(array $userInfo):bool
    {
        $data = [
            'openid' => $userInfo['openId'],
            'nickname' => $userInfo['nickName'],
            'avatar' => $userInfo['avatarUrl'],
            'sex' => $userInfo['gender'],
            'city' => $userInfo['city'],
            'language' => $userInfo['language'],
            'province' => $userInfo['province'],
            'country' => $userInfo['country'],
        ];
        $res1 = User::addUser($data,3);
        $data['uid'] = $res1;
        $res2 = self::insert($data);
        return $res1 && $res2;
    }

    /**
     * 更新
     * @param array $userInfo
     * @return bool
     */
    public static function updateUser(array $userInfo):bool
    {
        $uid = self::where("openid",$userInfo['openId'])->value("uid");
        $data = [
            'nickname' => $userInfo['nickName'],
            'avatar' => $userInfo['avatarUrl'],
            'sex' => $userInfo['gender'],
            'city' => $userInfo['city'],
            'language' => $userInfo['language'],
            'province' => $userInfo['province'],
            'country' => $userInfo['country'],
        ];
        $res1 = User::updateUser($data,$uid,3);
        $res2 = self::update($data,['openid'=>$userInfo['openId']]);
        return $res1 && $res2;
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