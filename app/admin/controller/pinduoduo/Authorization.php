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
use think\facade\Session;

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
        $provider = Session::get("provider");
        if (!$provider) return "未找到供应商！";
        $res = self::getToken($data['code'],$data['state'],$provider);
        Session::delete("provider");
        // 存储 redis
        Cache::store('redis')->set('store_'.$this->adminId,$res,$res['expires_in']-10);
        if ($data['state'] == 1000)
        {
            // 保存店铺信息
            if (self::getStoreInfo($provider, (array)$res, $data))
            {
                // 更新使用次数
                pModel::useNum($data['state']);
                return $this->redirect("/admin/pinduoduo.store/index");
            }
            else return "授权出错";
        }elseif ($data['state'] == 2000)
        {
            return $this->redirect("/admin/pinduoduo.goods/index");
        }elseif ($data['state'] == 3000)
        {
            return $this->redirect("/admin/pinduoduo.order/index");
        }

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
        return json_decode(Curl::app("https://open-api.pinduoduo.com/oauth/token","POST",json_encode($data))->header(["Content-Type:application/json"])->run(),true);
    }

    /**
     * 保存店铺信息
     * @param $provider
     * @param array $token
     * @param array $code
     * @return int|string
     */
    public function getStoreInfo($provider, array $token, array $code)
    {
        $data['type'] = 'pdd.mall.info.get';
        $data['client_id'] = $provider['client_id'];
        $data['access_token'] = $token['access_token'];
        $data['timestamp'] = time();
        $data['data_type'] = 'JSON';
        $res = json_decode(Curl::app("https://gw-api.pinduoduo.com/api/router","POST",json_encode($data))->header(["Content-Type:application/json"])->buildSign($provider['client_secret'])->run(),true);
        if (array_key_exists("mall_info_get_response",$res))
        {
            $ins['aid'] = $this->adminId;
            $ins['pid'] = $code['state'];
            $ins['mall_id'] = $token['owner_id'];
            $ins['user_name'] = $token['owner_name'];
            $ins['mall_name'] = $res['mall_info_get_response']['mall_name'];
            $ins['mall_desc'] = $res['mall_info_get_response']['mall_desc'];
            $ins['logo'] = $res['mall_info_get_response']['logo'];
            $ins['merchant_type'] = $res['mall_info_get_response']['merchant_type'];
            $ins['status'] = 1;
            $ins['create_user'] = $this->adminId;
            $ins['create_time'] = time();
            return sPmodel::insert($ins);
        }
    }
}