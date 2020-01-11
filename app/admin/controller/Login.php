<?php


namespace app\admin\controller;


use app\admin\controller\AuthController;

class Login extends AuthController
{
    protected $noNeedLogin = ['login'];

    public function login()
    {
        var_dump("login");
    }
}