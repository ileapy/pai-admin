<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;

/**
 * 账号管理
 * Class Admin
 * @package app\admin\controller\admin
 */
class Admin extends AuthController
{
    /**
     * 账号列表
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        return $this->fetch();
    }
}