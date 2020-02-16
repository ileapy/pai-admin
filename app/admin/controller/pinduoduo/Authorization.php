<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use learn\utils\Curl;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;
use app\admin\model\pinduoduo\PinduoduoStore as sPmodel;
use think\facade\Cache;

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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function accessauth(Request $request)
    {
        $data = Util::getMore([['code',''],['state',0]]);
        if ($data['code'] == "" || $data['state'] == 0) return "授权环境异常";
        $provider = pModel::get(['id'=>$data['state']]);
        if (!$provider) return "未找到供应商！";
        $res = self::getToken($data['code'],$data['state'],$provider);
        // 存储 redis
        Cache::store('redis')->set('store_'.$this->adminId,$res,$res['expires_in']-10);
        // 保存店铺信息
        self::getStoreInfo($provider, (array)$res);
    }

    /**
     * 获取token
     * @param string $code
     * @param string $pid
     * @param $provider
     * @return bool|string|void
     */
    public function getToken(string $code, string $pid,$provider)
    {
        $data['code'] = $code;
        $data['client_id'] = $provider['client_id'];
        $data['grant_type'] = "authorization_code";
        $data['client_secret'] = $provider['client_secret'];
        $curl = new Curl("https://open-api.pinduoduo.com/oauth/token","POST",$data);
        $curl->header(["Content-Type:application/json"]);
        return json_decode($curl->run(),true);
    }

    /**
     * 保存店铺信息
     * @param $provider
     * @param array $token
     */
    public function getStoreInfo($provider, array $token)
    {
        $data['type'] = 'pdd.mall.info.get';
        $data['client_id'] = $provider['client_id'];
        $data['access_token'] = $token['access_token'];
        $data['timestamp'] = time();
        $data['data_type'] = 'JSON';
        $curl = new Curl("https://gw-api.pinduoduo.com/api/router","POST",$data);
        $curl->header(["Content-Type:application/json"]);
        $curl->buildSign($provider['client_secret']);
        $res = $curl->run();
        var_dump($res);
    }
}