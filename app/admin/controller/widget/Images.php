<?php


namespace app\admin\controller\widget;


use app\admin\controller\AuthController;

class Images extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}