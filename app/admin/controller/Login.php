<?php


namespace app\admin\controller;


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
}