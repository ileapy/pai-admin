<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;

/**
 * 日志
 * Class AdminLog
 * @package app\admin\controller\admin
 */
class AdminLog extends AuthController
{
    protected $noNeedLogin = [];

    public function index()
    {
        return $this->fetch();
    }
}