<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use learn\services\WechatService;

/**
 * 微信回复
 * Class WechatReply
 * @package app\admin\model\wechat
 */
class WechatReply extends BaseModel
{
    use ModelTrait;

    /**
     * 关键词回复
     * @param string $keyword
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function reply(string $keyword)
    {
        file_put_contents("sd.log",$keyword);
        $res = self::where('key',$keyword)->where('status','1')->find();
        if(empty($res)) return WechatService::transfer();
        file_put_contents("reply.log",json_encode($res));
        switch ($res['type'])
        {
            case 'text':
                return WechatService::textMessage($res['data']);
                break;
            case 'image':
                return WechatService::imageMessage($res['data']);
                break;
            case 'news':
                return WechatService::newsMessage($res['data']);
                break;
            case 'voice':
                return WechatService::voiceMessage($res['data']);
                break;
        }
    }
}