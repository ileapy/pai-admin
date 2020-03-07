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
        $qrcode = WechatService::qrcodeService();
        $res = $qrcode->temporary("type=login&token=asdfghjklmn6677",300);
        $this->assign("qrcode",$qrcode->url($res['ticket']));
        return $this->fetch();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
