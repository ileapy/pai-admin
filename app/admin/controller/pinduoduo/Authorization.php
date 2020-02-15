<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;

/**
 * 权限
 * Class Authorization
 * @package app\admin\controller\pinduoduo
 */
class Authorization extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}