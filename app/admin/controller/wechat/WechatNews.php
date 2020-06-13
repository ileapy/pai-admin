<?php


namespace app\admin\controller\wechat;

use app\admin\controller\AuthController;
use app\admin\model\wechat\WechatNewsList;
use learn\services\UtilService as Util;
use app\admin\model\wechat\WechatNews as nModel;

/**
 * 图文管理
 * Class WechatNews
 * @package app\admin\controller\wechat
 */
class WechatNews extends AuthController
{
    /**
     * 列表
     * @return string
     * @throws \think\db\exception\DbException
     */
    public function index()
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',12],
        ]);
        $this->assign("item",WechatNewsList::system($where));
        return $this->fetch();
    }

    /**
     * 更新图文
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sync()
    {
        return nModel::sync() ? app("json")->success("更新成功") : app("json")->fail("更新出错");
    }

    /**
     * 添加
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function add($id = 0)
    {
        $data = [];
        if ($id) $data = WechatNewsList::getAllItem($id);
        if ($id == 0 || empty($data)) $data = [['title'=>'标题','thumb_url'=>'']];
        $this->assign("id",$id);
        $this->assign("data",$data);
        return $this->fetch();
    }
}