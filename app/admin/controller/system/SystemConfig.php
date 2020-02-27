<?php


namespace app\admin\controller\system;


use app\admin\controller\AuthController;
use app\admin\model\system\SystemConfig as cModel;
use app\admin\model\system\SystemConfigTab as tModel;
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

    /**
     * 列表
     * @param int $tab_id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst($tab_id = 0)
    {
        $this->assign("list",cModel::lst());
        $this->assign("tab",tModel::get($tab_id));
        return $this->fetch("list");
    }
}