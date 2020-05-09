<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use learn\services\MiniProgramService;
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
        if(empty($res)) $res = self::where('keyword','default')->where('status','1')->find();
        switch ($res['type'])
        {
            case 'text':
                return WechatService::textMessage($res['content']);
            case 'image':
                $res['content'] = json_decode($res['content'],true);
                return WechatService::imageMessage($res['content']['media_id']);
            case 'news':
                $res['content'] = json_decode($res['content'],true);
                return WechatService::newsMessage($res['content']['media_id']);
            case 'audio':
                $res['content'] = json_decode($res['content'],true);
                return WechatService::voiceMessage($res['content']['media_id']);
            case 'video':
                $res['content'] = json_decode($res['content'],true);
                return WechatService::videoMessage($res['content']['media_id']);
            default:
                return "没有找到指定内容！";
        }
    }

    /**
     * 小程序回复
     * @param string $keyword
     * @return mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function miniReply(string $keyword)
    {
        $res = self::where('keyword',$keyword)->where('status','1')->find();
        if(empty($res)) $res = self::where('keyword','default')->where('status','1')->find();
        switch ($res['type'])
        {
            case 'text':
                return MiniProgramService::textMessage($res['content']);
            case 'image':
                $res['content'] = json_decode($res['content'],true);
                return MiniProgramService::imageMessage($res['content']['media_id']);
            case 'miniprogrampage ':
            case 'link':
                break;
            default:
                return MiniProgramService::textMessage("没有找到指定内容！");
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
                $res = $media->uploadImage(app()->getRootPath().'public'.$data['content']);
                event("UploadMediaAfter",[$res,$data['content'],0]);
                $data['content'] = json_encode(['path'=>$data['content'],'media_id'=>$res['media_id']]);
                break;
            case 'video':
                $res = $media->uploadVideo(app()->getRootPath().'public'.$data['content']);
                event("UploadMediaAfter",[$res,$data['content'],0]);
                $data['content'] = json_encode(['path'=>$data['content'],'media_id'=>$res['media_id']]);
                break;
            case 'audio':
                $res = $media->uploadVoice(app()->getRootPath().'public'.$data['content']);
                event("UploadMediaAfter",[$res,$data['content'],0]);
                $data['content'] = json_encode(['path'=>$data['content'],'media_id'=>$res['media_id']]);
                break;
        }
        return self::be($data['keyword'],"keyword") ? self::update($data,['keyword'=>$data['keyword']]) : self::insert($data,true);
    }

    /**
     * 关键词列表
     * @param array $where
     * @return array
     */
    public static function systemPage(array $where)
    {
        $model = new self;
        $model = $model->where("keyword","not in", ['subscribe','default']);
        if ($where['keyword'] != "") $model = $model->where("keyword","like","%$where[keyword]%");
        if ($where['type'] != "") $model = $model->where("type",$where["type"]);
        if ($where['start_time']!="") $model = $model->where("create_time",">",strtotime($where['start_time']." 00:00:00"));
        if ($where['end_time']!="") $model = $model->where("create_time","<",strtotime($where['end_time']." 23:59:59"));
        $count = self::counts($model);
        $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select();
        if ($data) $data = $data->toArray() ?? [];
        return compact("data","count");
    }
}