<?php


namespace learn\services;


use EasyWeChat\Factory;

class MiniProgramService
{
    /**
     * 实例
     * @var null
     */
    private static $instance = null;

    /**
     * 配置参数
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function options()
    {
        $wechat = SystemConfigMore(['site_url','routine_appId','routine_appsecret']);
        $config = [];
        $config['mini_program'] = [
            'app_id'=>isset($wechat['routine_appId']) ? trim($wechat['routine_appId']):'',
            'secret'=>isset($wechat['routine_appsecret']) ? trim($wechat['routine_appsecret']):'',
            'token'=>isset($wechat['wechat_token']) ? trim($wechat['wechat_token']):'',
            'aes_key'=> isset($wechat['wechat_encodingaeskey']) ? trim($wechat['wechat_encodingaeskey']):''
        ];
        return $config;
    }

    /**
     * 应用
     * @param bool $cache
     * @return \EasyWeChat\MiniProgram\Application|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function application($cache = false)
    {
        (self::$instance === null || $cache === true) && (self::$instance = Factory::miniProgram(self::options()));
        return self::$instance;
    }

    /**
     * 接口
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function miniProgram()
    {
        return self::application()->customer_service;
    }

    /**
     * @param $code
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getUserInfo($code)
    {
        $userInfo = self::miniProgram()-custo;
        return $userInfo;
    }

    /**
     * 加密数据解密
     * @param $sessionKey
     * @param $iv
     * @param $encryptData
     * @return $userInfo
     */
    public static function encryptor($sessionKey, $iv, $encryptData){
        return self::miniProgram()->encryptor->decryptData($sessionKey, $iv, $encryptData);
    }

    /**
     * 上传临时素材接口
     * @return \EasyWeChat\Material\Temporary
     */
    public static function materialTemporaryService()
    {
        return self::miniprogram()->material_temporary;
    }

    /**
     * 客服消息接口
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function staffService()
    {
        return self::miniProgram()->customer_service;
    }

    /**
     * 微信小程序二维码生成接口
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function qrcodeService()
    {
        return self::miniProgram()->app_code;
    }

    /**微信小程序二维码生成接口不限量永久
     * @param $scene
     * @param null $page
     * @param null $width
     * @param null $autoColor
     * @param array $lineColor
     * @return \Psr\Http\Message\StreamInterface
     */
    public static function appCodeUnlimitService($scene, $page = null, $width = 430, $autoColor = false, $lineColor = ['r' => 0, 'g' => 0, 'b' => 0])
    {
        return self::qrcodeService()->appCodeUnlimit($scene,$page,$width,$autoColor,$lineColor);
    }


    /**
     * 模板消息接口
     * @return \EasyWeChat\Notice\Notice
     */
    public static function noticeService()
    {
        return self::miniprogram()->notice;
    }

    /**发送小程序模版消息
     * @param $openid
     * @param $templateId
     * @param array $data
     * @param null $url
     * @param null $defaultColor
     * @return mixed
     */
    public static function sendTemplate($openid,$templateId,array $data,$form_id,$link = null,$defaultColor = null)
    {
        $notice = self::noticeService()->to($openid)->template($templateId)->formId($form_id)->andData($data);
        $message = [];
        if($link !== null) $message = ['page'=>$link];
        if($defaultColor !== null) $notice->defaultColor($defaultColor);
        return $notice->send($message);
    }


    /**
     * 作为客服消息发送
     * @param $to
     * @param $message
     * @return bool
     */
    public static function staffTo($to, $message)
    {
        $staff = self::staffService();
        $staff = is_callable($message) ? $staff->message($message()) : $staff->message($message);
        $res = $staff->to($to)->send();
        HookService::afterListen('wechat_staff_to',compact('to','message'),$res);
        return $res;
    }

}