<?php


namespace app\admin\controller;

use learn\services\sms\QCloudSmsService;

class Test extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = [];
    // 无需权限的
    protected $noNeedRight = [];

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $sms = new QCloudSmsService(systemConfig("sms_appid"),systemConfig("sms_appkey"));
        $sms->setPhoneNumbers(['18438622618']);
        var_dump($sms->sendVoiceVerifySms(systemConfig("sms_login"),['123456'],""));
    }

}