<?php


namespace app\admin\controller\workflow;


use app\admin\controller\AuthController;

/**
 * Class Index
 * @package app\admin\controller\workflow
 */
class Index extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }
}