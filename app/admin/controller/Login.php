<?php


namespace app\admin\controller;

use app\admin\model\Admin;
use app\Request;
use learn\services\JsonService;
use learn\services\UtilService as Util;

class Login extends AuthController
{
    /**
     * 无需登录
     * @var array
     */
    protected $noNeedLogin = ['login','register','forget','captcha','verify'];

    /**
     * 登录
     * @return string
     * @throws \Exception
     */
    public function login()
    {
        return $this->view();
    }

    /**
     * 验证登录
     */
    public function verify(Request $request)
    {
        list($name,$pwd,$verify) = Util::postMore(['account','pwd','verify'],null,true);
        if (empty($name) || empty($pwd) || empty($verify)) return app("json")->fail("账号、密码和验证码不能为空！");
        var_dump($request);
//        Admin::login();
    }

    /**
     * 注册
     * @return string
     * @throws \Exception
     */
    public function register()
    {
        return $this->view();
    }

    /**
     * 忘记密码
     * @return string
     * @throws \Exception
     */
    public function forget()
    {
        return $this->view();
    }

    /**
     * 验证码
     * @return \think\Response
     */
    public function captcha()
    {
        ob_clean();
        return captcha();
    }
}