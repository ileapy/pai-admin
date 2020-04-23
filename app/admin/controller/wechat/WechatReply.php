<?php


namespace app\admin\controller\wechat;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\UtilService as Util;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use app\admin\model\wechat\WechatReply as RModel;

/**
 * Class WechatReply
 * @package app\admin\controller\wechat
 */
class WechatReply extends AuthController
{
    /**
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 列表
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['keyword',''],
            ['page',1],
            ['limit',20],
            ['end_time',''],
            ['start_time',''],
            ['type',''],
        ]);
        return app("json")->layui(RModel::systemPage($where));
    }

    /**
     * 添加
     * @return string
     * @throws \Exception
     */
    public function add()
    {
        return $this->fetch("template");
    }

    /**
     * 添加
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function edit($id = 0)
    {
        if ($id == 0) return app("json")->fail("未选择修改的关键词");
        $data = RModel::where("id",$id)->find();
        $this->assign(self::value($data));
        return $this->fetch("template");
    }

    /**
     * 保存关键词
     * @param string $id
     * @return
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function save($id="")
    {
        $data = Util::postMore([
            ['keyword',''],
            ['content',0],
            ['type',''],
            ['status',1]
        ]);
        if ($data['keyword'] == "") return app("json")->fail("关键词不能为空");
        if ($data['content'] == "") return app("json")->fail("回复内容不能为空");
        if ($data['type'] == "") return app("json")->fail("类型不能为空");
        if ($data['status'] == "") return app("json")->fail("状态不能为空");
        if (RModel::be($data['keyword'],"keyword"))
        {
            $data['update_time'] = time();
            $data['update_user'] = $this->adminId;
        }else
        {
            $data['create_time'] = time();
            $data['create_user'] = $this->adminId;
        }
        return RModel::saveReply($data) ? app("json")->success("操作成功",'code') : app("json")->fail("操作失败");
    }

    /**
     * 关注
     * @return string
     * @throws \Exception
     */
    public function focus()
    {
        $this->assign("keyword",'subscribe');
        $data = RModel::where("keyword",'subscribe')->find();
        $this->assign("title","关注时回复");
        $this->assign(self::value($data));
        return $this->fetch("default");
    }

    /**
     * 默认回复
     * @return string
     * @throws \Exception
     */
    public function default()
    {
        $this->assign("keyword",'default');
        $data = RModel::where("keyword",'default')->find();
        $this->assign("title","默认回复");
        $this->assign(self::value($data));
        return $this->fetch("default");
    }

    /**
     * 获取内容
     * @param $data
     * @return array
     */
    public function value($data)
    {
        switch ($data['type'])
        {
            case 'text':
                $content = $data['content'];
                $type = "text";
                break;
            case 'image':
                $content = json_decode($data['content'],true)['path'];
                $type = "image";
                break;
            case 'video':
                $content = json_decode($data['content'],true)['path'];
                $type = "video";
                break;
            case 'audio':
                $content = json_decode($data['content'],true)['path'];
                $type = "audio";
                break;
            default:
                $content = "";
                $type = "text";
        }
        $status = $data['status'];
        $keyword = $data['keyword'];
        return compact("type","content", "status","keyword");
    }

    /**
     * 关键词回复
     * @return string
     * @throws \Exception
     */
    public function keyword()
    {
        return $this->fetch();
    }
}