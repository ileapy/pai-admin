<?php


namespace app\admin\controller;

use app\admin\model\admin\Admin;
use app\admin\model\admin\Admin as adminModel;
use app\Request;
use learn\services\UtilService as Util;
use think\facade\Route as Url;

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
        return $this->fetch();
    }

    /**
     * 验证登录
     */
    public function verify()
    {
        list($account,$pwd,$verify) = Util::postMore(['account','pwd','verify'],null,true);
        if (empty($account) || empty($pwd)) return app("json")->fail("账号、密码和验证码不能为空！");
        // 验证码验证
        if (!captcha_check($verify)) return app("json")->fail("验证码不正确！");
        // 验证登录
        if (!adminModel::login($account,$pwd)) return app("json")->fail("登录失败！");
        return app("json")->success("登录成功！");
    }

    /**
     * 注册
     * @return string
     * @throws \Exception
     */
    public function register()
    {
        return $this->fetch();
    }

    /**
     * 忘记密码
     * @return string
     * @throws \Exception
     */
    public function forget()
    {
        return $this->fetch();
    }

    /**
     * 退出登陆
     * @return mixed
     */
    public function logout()
    {
        return Admin::clearLoginInfo() ? app("json")->success("操作成功") : app("json")->fail("操作失败");
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