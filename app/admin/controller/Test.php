<?php


namespace app\admin\controller;

use app\Request;
use learn\services\crawler\QQService;
use learn\services\sms\QCloudSmsService;
use learn\services\storage\QcloudCoService;
use think\facade\Cache;

class Test extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = [];
    // 无需权限的
    protected $noNeedRight = [];

    public function index()
    {
//        $res = QCloudSmsService::app()->setPhoneNumbers(['18438622618'])->sendSingleSms(systemConfig("sms_login"),['123456'],"");
//        var_dump($res);
        //var_dump($sms->sendSingleSms(systemConfig("sms_login"),['123456'],""));
//        $wechat = SystemConfigMore(['wechat_appid','wechat_appsecret','wechat_token','wechat_aeskey','wechat_encry']);
//        Cache::store('redis')->set('abc','1234567890xsaxazczxc',3600);
//        var_dump($wechat);
//        echo json_encode(QQService::app("mzc00200mnujrjg","movie")->message());
//        var_dump(QcloudCoService::put("/upload/image/20200417/45f71819c29a85151806a57609fdade0.jpeg"));
    }
}