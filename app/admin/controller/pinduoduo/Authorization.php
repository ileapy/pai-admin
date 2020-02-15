<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use learn\utils\Curl;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;

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
        $data = Util::getMore([['code',''],['state',0],['client_id','']]);
        if ($data['code'] == "" || $data['state'] == 0 || $data['client_id'] == "") return "授权环境异常";
        var_dump(self::getToken($data['code'],$data['client_id']));
    }

    /**
     * 获取token
     * @param string $code
     * @param string $client_id
     * @return bool|string|void
     */
    public function getToken(string $code, string $client_id)
    {
        if (!$code) return Json::fail("code为空");
        $provider = pModel::get(['client_id'=>$client_id]);
        if (!$provider) return Json::fail("供应商不存在");
        $data['code'] = $code;
        $data['client_id'] = $provider['client_id'];
        $data['grant_type'] = $provider['grant_type'];
        $data['client_secret'] = $provider['client_secret'];
        $curl = new Curl("https://open-api.pinduoduo.com/oauth/token","POST",$data);
        $res = $curl->run();
        return $res;
    }
}