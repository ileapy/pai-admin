<?php


namespace learn\subscribes;

use app\admin\model\wechat\WechatMessage;

/**
 * Class WechatMessageSubscribe
 * @package learn\subscribes
 */
class WechatMessageSubscribe
{
    /**
     * 用户信息前置操作
     * @param $event
     */
    public function onMessageBefore($event)
    {
        list($message) = $event;
        file_put_contents("db.log", strtolower($message->MsgType));
        $event = isset($message->MsgType) && strtolower($message->MsgType) == 'event' ? strtolower($message->Event) : strtolower($message->MsgType) ;
        file_put_contents("da.log", $event);
        WechatMessage::saveMessage($message->FromUserName, $event, json_encode($message,true));
    }

    /**
     * 用户取消关注公众号前置操作
     * @param $event
     */
    public function onEventUnsubscribeBefore($event)
    {
        list($message) = $event;
        WechatUser::unSubscribe($message->FromUserName);
    }

    /**
     * 用户取消关注公众号前置操作
     * @param $event
     */
    public function onEventSubscribeBefore($event)
    {
        list($message) = $event;
        WechatUser::subscribe($message->FromUserName);
    }
}