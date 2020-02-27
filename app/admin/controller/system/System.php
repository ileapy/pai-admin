<?php


namespace app\admin\controller\system;


use app\admin\controller\AuthController;

class System extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}