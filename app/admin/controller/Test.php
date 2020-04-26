<?php


namespace app\admin\controller;

use learn\services\crawler\QQService;
use learn\services\sms\QCloudSmsService;
use think\facade\Cache;

class Test extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = [];
    // 无需权限的
    protected $noNeedRight = [];

    /**
     *
     */
    public function index()
    {
//        $sms = new QCloudSmsService(systemConfig("sms_appid"),systemConfig("sms_appkey"));
//        $sms->setPhoneNumbers(['18438622618']);
//        //var_dump($sms->sendSingleSms(systemConfig("sms_login"),['123456'],""));
//        $wechat = SystemConfigMore(['wechat_appid','wechat_appsecret','wechat_token','wechat_aeskey','wechat_encry']);
//        Cache::store('redis')->set('abc','1234567890xsaxazczxc',3600);
//        var_dump($wechat);
        echo json_encode(QQService::app("mzc00200xvthvzj","t")->message());
    }

}