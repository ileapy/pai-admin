<?php


namespace app\admin\controller\system;


use app\admin\controller\AuthController;

/**
 * 系统配置
 * Class SystemConfig
 * @package app\admin\controller\system
 */
class SystemConfig extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}