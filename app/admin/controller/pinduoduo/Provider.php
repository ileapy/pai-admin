<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;

/**
 * 供应商信息
 * Class Provider
 * @package app\admin\controller\pinduoduo
 */
class Provider extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}