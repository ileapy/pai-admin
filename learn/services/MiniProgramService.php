<?php


namespace learn\services;


use EasyWeChat\Factory;

/**
 * 小程序
 * Class MiniProgramService
 * @package learn\services
 */
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
        $wechat = SystemConfigMore(['miniprogram_appid','miniprogram_appsecret']);
        return [
            'app_id'=>isset($wechat['miniprogram_appid']) ? trim($wechat['miniprogram_appid']):'',
            'secret'=>isset($wechat['miniprogram_appsecret']) ? trim($wechat['miniprogram_appsecret']):'',
            'response_type' => 'array',
        ];
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
        return self::application();
    }

    /**
     * auth
     * @return \EasyWeChat\MiniProgram\Auth\Client
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function auth()
    {
        return self::miniProgram()->auth;
    }

    /**
     * session
     * @param string $code
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function session(string $code)
    {
        return self::auth()->session($code);
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
     * 加密数据解密
     * @param $sessionKey
     * @param $iv
     * @param $encryptData
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function encryptor($sessionKey, $iv, $encryptData){
        return self::miniProgram()->encryptor->decryptData($sessionKey, $iv, $encryptData);
    }

    /**
     * 微信小程序二维码生成接口
     * @return \EasyWeChat\MiniProgram\AppCode\Client
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function qrCodeService()
    {
        return self::miniProgram()->app_code;
    }

    /**
     * 模板消息接口
     * @return \EasyWeChat\MiniProgram\TemplateMessage\Client
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function templateMessageService()
    {
        return self::miniProgram()->template_message;
    }

    /**
     * 发送小程序模版消息
     * @param $openid
     * @param $templateId
     * @param array $data
     * @param $form_id
     * @param null $url
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function sendTemplate($openid,$templateId,array $data,$form_id,$url = null)
    {
        return self::templateMessageService()->send([
            'touser' => $openid,
            'template_id' => $templateId,
            'page' => $url,
            'form_id' => $form_id,
            'data' => $data
        ]);
    }
}