<?php


namespace learn\services;

use app\admin\model\system\SystemConfig;
use EasyWeChat\Work\Application;
use think\Response;

/**
 * 微信公众号
 * Class WechatService
 * @package learn\services
 */
class WechatService
{
    /**
     * 实例
     * @var null
     */
    private static $instance = null;

    /**
     * 配置
     * @return array
     */
    public static function options()
    {
        $wechat = SystemConfigMore(['wechat_appid','wechat_appsecret','wechat_token','wechat_aeskey','wechat_encry']);
        var_dump($wechat);
        $payment = SystemConfigMore(['pay_weixin_mchid','pay_weixin_client_cert','pay_weixin_client_key','pay_weixin_key','pay_weixin_open']);
        $config = [
            'app_id'=>isset($wechat['wechat_appid']) ? trim($wechat['wechat_appid']) :'',
            'secret'=>isset($wechat['wechat_appsecret']) ? trim($wechat['wechat_appsecret']) :'',
            'token'=>isset($wechat['wechat_token']) ? trim($wechat['wechat_token']) :'',
            'guzzle' => [
                'timeout' => 10.0, // 超时时间（秒）
            ],
        ];
        if(isset($wechat['wechat_encode']) && (int)$wechat['wechat_encode']>0 && isset($wechat['wechat_encodingaeskey']) && !empty($wechat['wechat_encodingaeskey']))
            $config['aes_key'] =  $wechat['wechat_encodingaeskey'];
        if(isset($payment['pay_weixin_open']) && $payment['pay_weixin_open'] == 1){
            $config['payment'] = [
                'merchant_id'=>trim($payment['pay_weixin_mchid']),
                'key'=>trim($payment['pay_weixin_key']),
                'cert_path'=>realpath('.'.$payment['pay_weixin_client_cert']),
                'key_path'=>realpath('.'.$payment['pay_weixin_client_key']),
                //'notify_url'=>SystemConfigService::get('site_url').Url::buildUrl('wap/Wechat/notify')
                'notify_url'=>SystemConfigService::get('site_url') . '/api/wechat/notify'
            ];
        }
        return $config;
    }



    public static function application($cache = false)
    {
        (self::$instance === null || $cache === true) && (self::$instance = new Application(self::options()));
        return self::$instance;
    }

    public static function serve():Response
    {
        $wechat = self::application(true);
        $server = $wechat->server;
        self::hook($server);
        $response = $server->serve();
        return response($response->getContent());
    }

    /**
     * 监听
     * @param Guard $server
     */
    private static function hook($server)
    {
        $server->setMessageHandler(function($message){
            event('WechatMessageBefore',[$message]);
            switch ($message->MsgType){
                case 'event':
                    switch (strtolower($message->Event)){
                        case 'subscribe':
                            $response = WechatReply::reply('subscribe');
                            if(isset($message->EventKey)){
                                if ($message->EventKey && ($qrInfo = QrcodeService::getQrcode($message->Ticket, 'ticket'))) {
                                    QrcodeService::scanQrcode($message->Ticket, 'ticket');
                                    if(strtolower($qrInfo['third_type']) == 'spread'){
                                        try{
                                            $spreadUid = $qrInfo['third_id'];
                                            $uid = WechatUser::openidToUid($message->FromUserName, 'openid');
                                            if($spreadUid == $uid) return '自己不能推荐自己';
                                            $userInfo = User::getUserInfo($uid);
                                            if($userInfo['spread_uid']) return '已有推荐人!';
                                            if(!User::setSpreadUid($userInfo['uid'],$spreadUid)){
                                                $response = '绑定推荐人失败!';
                                            }
                                        }catch (\Exception $e){
                                            $response = $e->getMessage();
                                        }
                                    }
                                }
                            }
                            break;
                        case 'unsubscribe':
                            event('WechatEventUnsubscribeBefore',[$message]);
                            break;
                        case 'scan':
                            $response = WechatReply::reply('subscribe');
                            if ($message->EventKey && ($qrInfo = QrcodeService::getQrcode($message->Ticket, 'ticket'))) {
                                QrcodeService::scanQrcode($message->Ticket, 'ticket');
                                if(strtolower($qrInfo['third_type']) == 'spread'){
                                    try{
                                        $spreadUid = $qrInfo['third_id'];
                                        $uid = WechatUser::openidToUid($message->FromUserName, 'openid');
                                        if($spreadUid == $uid) return '自己不能推荐自己';
                                        $userInfo = User::getUserInfo($uid);
                                        if($userInfo['spread_uid']) return '已有推荐人!';
                                        if(User::setSpreadUid($userInfo['uid'],$spreadUid) === false){
                                            $response = '绑定推荐人失败!';
                                        }
                                    }catch (\Exception $e){
                                        $response = $e->getMessage();
                                    }
                                }
                            }
                            break;
                        case 'location':
                            $response = MessageRepositories::wechatEventLocation($message);
                            break;
                        case 'click':
                            $response = WechatReply::reply($message->EventKey);
                            break;
                        case 'view':
                            $response = MessageRepositories::wechatEventView($message);
                            break;
                    }
                    break;
                case 'text':
                    $response = WechatReply::reply($message->Content,$message->FromUserName);
                    break;
                case 'image':
                    $response = MessageRepositories::wechatMessageImage($message);
                    break;
                case 'voice':
                    $response = MessageRepositories::wechatMessageVoice($message);
                    break;
                case 'video':
                    $response = MessageRepositories::wechatMessageVideo($message);
                    break;
                case 'location':
                    $response = MessageRepositories::wechatMessageLocation($message);
                    break;
                case 'link':
                    $response = MessageRepositories::wechatMessageLink($message);
                    break;
                // ... 其它消息
                default:
                    $response = MessageRepositories::wechatMessageOther($message);
                    break;
            }
            return $response;
        });
    }
}