<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * 微信消息
 * Class WechatMessage
 * @package app\admin\model\wechat
 */
class WechatMessage extends BaseModel
{
    use ModelTrait;

    /**
     * 保存信息
     * @param string $openid
     * @param string $type
     * @param string $message
     * @return WechatMessage|\think\Model
     */
    public static function saveMessage(string $openid, string $type, string $message)
    {
        $data = compact("openid","type", "message");
        $data['add_time'] = time();
        file_put_contents("xxx.log",json_encode($data,true));
        return self::create($data);
    }
}