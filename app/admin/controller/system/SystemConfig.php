<?php


namespace app\admin\controller\system;


use app\admin\controller\AuthController;

/**
 * 系统配置
 * Class SystemConfig
 * @package app\admin\controller\system
 */
class SystemConfig extends AuthController
{
    /**
     * 基础配置
     * @return string
     * @throws \Exception
     */
    public function base()
    {
        return $this->fetch();
    }

    /**
     * 上传配置
     * @return string
     * @throws \Exception
     */
    public function upload()
    {
        return $this->fetch();
    }

    /**
     * 短信配置
     * @return string
     * @throws \Exception
     */
    public function sms()
    {
        return $this->fetch();
    }

    /**
     *邮件配置
     * @return string
     * @throws \Exception
     */
    public function email()
    {
        return $this->fetch();
    }
}