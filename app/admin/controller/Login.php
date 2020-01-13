<?php


namespace app\admin\controller;

use think\Request;
use app\admin\controller\AuthController;

class Login extends AuthController
{
    protected $noNeedLogin = ['login'];

    /**
     * 登录
     * @return string
     * @throws \Exception
     */
    public function login()
    {
        return $this->view();
    }

    /**
     * 注册
     * @return string
     * @throws \Exception
     */
    public function register()
    {
        return $this->view();
    }

    /**
     * 忘记密码
     * @return string
     * @throws \Exception
     */
    public function forget()
    {
        return $this->view();
    }
}