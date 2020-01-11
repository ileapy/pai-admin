<?php


namespace app\admin\controller;


use app\admin\controller\AuthController;

class Login extends AuthController
{
    protected $noNeedLogin = ['login'];

    /**
     * 登录
     */
    public function login()
    {
        var_dump("login");
    }
}