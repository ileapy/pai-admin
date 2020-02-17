<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;
use app\admin\model\pinduoduo\PinduoduoStore as sModel;
use think\facade\Session;

/**
 * 商品信息
 * Class Goods
 * @package app\admin\controller\pinduoduo
 */
class Goods extends AuthController
{
    /**
     * 商品列表
     * @return string|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $store = sModel::isBingInfo($this->adminId);
        if (!$store) $this->assign("isBind",false);
        else
        {
            if (!authIsExit($this->adminId))
            {
                $provider = pModel::get($store['pid']);
                if (!$provider)
                {
                    $this->assign("isBind",true);
                    $this->assign("provider",$provider);
                }
                else
                {
                    Session::set("provider",$provider);
                    return $this->redirect("https://mms.pinduoduo.com/open.html?response_type=code&client_id={$provider['client_id']}&redirect_uri=http://learn.leapy.cn/admin/pinduoduo.authorization/accessauth&state=2000");
                }
            }else $this->assign("isBind",true);
        }
        return $this->fetch();
    }
}