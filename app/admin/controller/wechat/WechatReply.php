<?php


namespace app\admin\controller\wechat;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\JsonService as Json;
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
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 权限列表
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        return Json::successlayui(RModel::systemPage());
    }

    /**
     * 添加
     * @param int $pid
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function add($pid = 0)
    {
        $form = array();
        $form[] = Elm::input('name','权限名称')->col(10);
        $form[] = Elm::input('icon','图标')->col(10);
        $form[] = Elm::input('module','模块名')->col(10);
        $form[] = Elm::input('controller','控制器名')->col(10);
        $form[] = Elm::input('action','方法名')->col(10);
        $form[] = Elm::input('params','参数')->col(10);
        $form[] = Elm::number('rank','排序')->col(10);
        $form[] = Elm::radio('is_menu','是否菜单',1)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save')->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 添加
     * @param int $id
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id = 0)
    {
        if (!$id) return app("json")->fail("权限id不能为空");
        $ainfo = RModel::get($id);
        if (!$ainfo) return app("json")->fail("没有该权限");
        $form = array();
        $form[] = Elm::input('name','权限名称',$ainfo['name'])->col(10);
        $form[] = Elm::input('icon','图标',$ainfo['icon'])->col(10);
        $form[] = Elm::input('module','模块名',$ainfo['module'])->col(10);
        $form[] = Elm::input('controller','控制器名',$ainfo['controller'])->col(10);
        $form[] = Elm::input('action','方法名',$ainfo['action'])->col(10);
        $form[] = Elm::input('params','参数',$ainfo['params'])->col(10);
        $form[] = Elm::number('rank','排序',$ainfo['rank'])->col(10);
        $form[] = Elm::radio('is_menu','是否菜单',$ainfo['is_menu'])->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(10);
        $form[] = Elm::radio('status','状态',$ainfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save',['id'=>$id])->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 保存
     * @param $id
     */
    public function save($id="")
    {
        $data = Util::postMore([
            ['name',''],
            ['pid',0],
            ['icon',''],
            ['module',''],
            ['controller',''],
            ['action',''],
            ['params',''],
            ['rank',0],
            ['is_menu',1],
            ['status',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("权限名称不能为空");
        if ($data['pid'] == "") return app("json")->fail("上级归属不能为空");
        if ($data['module'] == "") return app("json")->fail("模块名不能为空");
        if ($data['controller'] == "") return app("json")->fail("控制器名不能为空");
        if ($data['action'] == "") return app("json")->fail("方法名不能为空");
        $data['path'] = '/'.$data['module'].'/'.$data['controller'].'/'.$data['action'];
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = RModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = RModel::update($data,['id'=>$id]);
        }
        return $res ? Json::success("操作成功") : app("json")->fail("操作失败");
    }
}