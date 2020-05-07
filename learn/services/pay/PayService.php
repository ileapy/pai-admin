<?php


namespace learn\services\pay;

use Yansongda\Pay\Pay;

/**
 * 支付
 * Class PayService
 * @package learn\services\pay
 */
class PayService
{
    /**
     * 支付类型 支付宝 or 微信
     * @var null
     */
    public $type = null;

    /**
     * 支付方式
     * @var null
     */
    public $method = null;

    /**
     * 实例
     * @var null
     */
    public static $instance = null;

    /**
     * 配置
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function options()
    {
        switch ($this->type)
        {
            case 'wechat':
                $params = systemConfigMore(['pay_wechat_appid','pay_wechat_app_id','pay_wechat_miniapp_id','pay_wechat_mch_id','pay_wechat_key','pay_wechat_apiclient_cert','pay_wechat_apiclient_key']);
                $config = [
                    'appid' => $params['pay_wechat_appid'], // APP APPID
                    'app_id' => $params['pay_wechat_app_id'], // 公众号 APPID
                    'miniapp_id' => $params['pay_wechat_miniapp_id'], // 小程序 APPID
                    'mch_id' => $params['pay_wechat_mch_id'],
                    'key' => $params['pay_wechat_key'],
                    'notify_url' => self::notify_url($this->type,$this->method),
                    'cert_client' => realpath(".".$params['pay_wechat_apiclient_cert']), // optional，退款等情况时用到
                    'cert_key' => realpath(".".$params['pay_wechat_apiclient_key']),// optional，退款等情况时用到
                    'log' => [ // optional
                        'file' => './logs/wechat.log',
                        'level' => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
                        'type' => 'single', // optional, 可选 daily.
                        'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
                    ],
                    'http' => [ // optional
                        'timeout' => 5.0,
                        'connect_timeout' => 5.0,
                        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
                    ],
                    //'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。 设置就是沙箱环境
                ];
                break;
            case 'alipay':
                $config = [];
                break;
        }
        return $config;
    }

    /**
     * 回调地址
     * @param string $type
     * @param string $method
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function notify_url(string $type, string $method)
    {
        if ($type == "wechat")
        {
            switch ($method)
            {
                case 'mp':
                    return systemConfig("domain").Url("/api/wechat/notify");
                case 'miniapp':
                    return systemConfig("domain").Url("/api/mini_program/notify");
                case 'scan':
                    return systemConfig("domain").Url("/api/wechat/notify");
            }
        }
        elseif ($type == "alipay")
        {
            return "";
        }
    }

    /**
     * PayService constructor.
     * @param string $type
     * @param string $method
     */
    public function __construct(string $type, string $method)
    {
        $this->type = $type;
        $this->method = $method;
    }

    /**
     * app
     * @param string $type
     * @param string $method
     * @return PayService|null
     */
    public static function app(string $type, string $method)
    {
        (self::$instance === null) && (self::$instance = new self($type,$method));
        return self::$instance;
    }

    /**
     * 支付对象
     * @return \Yansongda\Pay\Gateways\Alipay|\Yansongda\Pay\Gateways\Wechat
     */
    public static function server()
    {
        switch (self::$instance->type)
        {
            case 'wechat':
                return Pay::wechat(self::$instance->options());
            case 'alipay':
                return Pay::alipay(self::$instance->options());
        }
    }

    /**
     * 支付
     * @param array $order
     * @return bool
     */
    public function pay(array $order)
    {
        try {
            switch (self::$instance->method)
            {
                case 'mp':
                    return self::server()->mp($order);
                case 'wap':
                    return self::server()->wap($order);
                case 'miniapp':
                    return self::server()->miniapp($order);
                case 'scan':
                    return self::server()->scan($order);
            }
        }catch (\Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }
    }
}