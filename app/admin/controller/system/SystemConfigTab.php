<?php


namespace app\admin\controller\system;


use app\admin\controller\AuthController;

class SystemConfigTab extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}