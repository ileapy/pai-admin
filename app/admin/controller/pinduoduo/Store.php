<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;

/**
 * 店铺信息
 * Class Store
 * @package app\admin\controller\pinduoduo
 */
class Store extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}