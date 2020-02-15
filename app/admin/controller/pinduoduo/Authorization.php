<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;

/**
 * 权限
 * Class Authorization
 * @package app\admin\controller\pinduoduo
 */
class Authorization extends AuthController
{
    /**
     * 验证返回code
     * @param Request $request
     * @return string
     */
    public function accessauth(Request $request)
    {
        $data = Util::getMore([['code',''],['state',0]]);
        if ($data['code'] == "" || $data['state'] == 0) return "授权环境异常";
        var_dump($data);
    }
}