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
        $res = self::where('keyword',$keyword)->where('status','1')->find();
        if(empty($res)) return WechatService::textMessage(self::where('keyword','default')->value("content"));
        switch ($res['type'])
        {
            case 'text':
                return WechatService::textMessage($res['content']);
                break;
            case 'image':
                return WechatService::imageMessage($res['content']);
                break;
            case 'news':
                return WechatService::newsMessage($res['content']);
                break;
            case 'voice':
                return WechatService::voiceMessage($res['content']);
                break;
        }
    }

    /**
     * 保存数据
     * @param array $data
     * @return bool
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function saveReply(array $data)
    {
        // 微信资源文件上传
        $media = WechatService::mediaService();
        switch ($data['type'])
        {
            case 'image':
                $res = $media->uploadImage($data['content']);
                var_dump($res);
                break;
            case 'video':
                $res = $media->uploadVideo($data['content']);
                var_dump($res);
                break;
            case 'audio':
                $res = $media->uploadVoice($data['content']);
                var_dump($res);
                break;
        }
        return self::be($data['keyword'],"keyword") ? self::update($data,['keyword'=>$data['keyword']]) : self::insert($data,true);
    }
}