<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;

/**
 * 订单信息
 * Class Order
 * @package app\admin\controller\pinduoduo
 */
class Order extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}