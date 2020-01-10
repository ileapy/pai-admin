<?php


namespace app\admin\controller;


use app\admin\BaseController;
use think\facade\View;

class Index extends BaseController
{
    /**
     * 后台首页
     * @return \think\response\View
     */
    public function index()
    {
        return View::fetch();
    }
}