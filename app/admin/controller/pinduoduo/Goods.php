<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;
use app\admin\model\pinduoduo\PinduoduoStore as sModel;
use think\facade\Cache;
use think\facade\Session;

/**
 * 商品信息
 * Class Goods
 * @package app\admin\controller\pinduoduo
 */
class Goods extends AuthController
{
    public function index()
    {
        $store = sModel::isBingInfo($this->adminId);
        if (!$store) $this->assign("isBind",false);
        else
        {
            if (!self::authIsExit())
            {
                $provider = pModel::get($store['pid']);
                if (!$provider) return "";
                Session::set("provider",$provider);
                return $this->redirect("https://mms.pinduoduo.com/open.html?response_type=code&client_id={$provider['client_id']}&redirect_uri=http://learn.leapy.cn/admin/pinduoduo.authorization/accessauth&state=2000");
            }
        }
        return $this->fetch();
    }

    /**
     * 判断授权信息是否存在
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function authIsExit(): bool
    {
        return Cache::store('redis')->has('store_'.$this->adminId);
    }
}