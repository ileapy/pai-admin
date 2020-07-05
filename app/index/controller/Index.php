<?php
namespace app\index\controller;

use learn\basic\index\BaseController;
use learn\services\WechatService;

/**
 * Class Index
 * @package app\index\controller
 */
class Index extends BaseController
{
    /**
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        $this->assign("logo",systemConfig("favicon"));
        return $this->fetch();
    }
}
