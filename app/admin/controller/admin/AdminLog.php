<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;

class AdminLog extends AuthController
{
    protected $noNeedLogin = ['*'];

    public function index()
    {
        var_dump(123);
    }
}