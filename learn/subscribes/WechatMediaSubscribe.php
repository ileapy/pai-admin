<?php


namespace learn\subscribes;

use app\admin\model\wechat\WechatMedia;

/**
 * 资源
 * Class WechatMediaSubscribe
 * @package learn\subscribes
 */
class WechatMediaSubscribe
{
    /**
     * 上传素材之后
     * @param $event
     */
    public function onUploadMediaAfter($event)
    {
        list($res,$path,$temporary) = $event;
        WechatMedia::insert(['type'=>$res['type'],'media_id'=>$res['media_id'],'create_time'=>$res['created_at'],'path'=>$path,'temporary'=>$temporary]);
    }
}