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
    public function index()
    {
        return $this->fetch();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
