<?php


namespace app\admin\controller\mini;


use app\admin\controller\AuthController;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\UtilService as Util;
use app\admin\model\mini\MiniVideoTag as tagModel;
/**
 * Class MiniVideoTag
 * @package app\admin\controller\mini
 */
class MiniVideoTag extends AuthController
{
    /**
     * 列表
     * @param Request $request
     * @return mixed
     */
    public function lst(Request $request)
    {
       $where = Util::postMore([
           ['name',''],
           ['status',''],
           ['type',''],
           ['page',1],
           ['limit',20]
       ]);
       return app("json")->layui(tagModel::systemPage($where));
    }

    /**
     * 添加账号
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function add(Request $request)
    {
        $form = array();
        $form[] = Elm::input('name','标签名称')->col(10);
        $form[] = Elm::select('type','标签类型')->options(function (){
            $menu[] = ['label'=>"电影",'value'=>"movie"];
            $menu[] = ['label'=>"电视剧",'value'=>"tv"];
            return $menu;
        })->col(10);
        $form[] = Elm::number('rank','排序',0)->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save')->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 修改账号
     * @param string $id
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id="")
    {
        if (!$id) return app("json")->fail("标签id不能为空");
        $ainfo = tagModel::get($id);
        if (!$ainfo) return app("json")->fail("没有该标签");
        $form = array();
        $form[] = Elm::input('name','标签名称',$ainfo['name'])->col(10);
        $form[] = Elm::select('type','标签类型',$ainfo['type'])->options(function (){
            $menu[] = ['label'=>"电影",'value'=>"movie"];
            $menu[] = ['label'=>"电视剧",'value'=>"tv"];
            return $menu;
        })->col(10);
        $form[] = Elm::number('rank','排序',$ainfo['rank'])->col(10);
        $form[] = Elm::radio('status','状态',$ainfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save',['id'=>$id])->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 保存修改
     * @param string $id
     * @return mixed
     */
    public function save($id="")
    {
        $data = Util::postMore([
            ['name',''],
            ['type',''],
            ['rank',0],
            ['status',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("标签名称不能为空");
        if ($data['type'] == "") return app("json")->fail("标签类型不能为空");
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = tagModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = tagModel::update($data,['id'=>$id]);
        }
        return $res ? app("json")->success("操作成功",'code') : app("json")->fail("操作失败");
    }
}