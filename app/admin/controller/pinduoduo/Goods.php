<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;

/**
 * 商品信息
 * Class Goods
 * @package app\admin\controller\pinduoduo
 */
class Goods extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}