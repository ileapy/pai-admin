<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;

class Authorization extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}