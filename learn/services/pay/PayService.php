<?php


namespace learn\services\pay;

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
     * 配置
     */
    public static function options()
    {

    }
}