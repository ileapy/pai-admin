<?php


namespace app\admin\controller\mini;

use app\admin\controller\AuthController;
use app\admin\model\mini\MiniVideo as videoModel;
use app\admin\model\mini\MiniVideoItem;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\UtilService as Util;

/**
 * Class MiniVideo
 * @package app\admin\controller\mini
 */
class MiniVideo extends AuthController
{
    /**
     * 列表
     * @param Request $request
     * @return mixed
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['title',''],
            ['status',''],
            ['type',''],
            ['page',1],
            ['limit',20]
        ]);
        return app("json")->layui(videoModel::systemPage($where));
    }

    /**
     * 自动添加
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function autoAdd(Request $request)
    {
        $form = array();
        $form[] = Elm::select('type','视频类型')->options(function (){
            $menu[] = ['label'=>"电影",'value'=>"movie"];
            $menu[] = ['label'=>"电视剧",'value'=>"tv"];
            return $menu;
        })->col(18);
        $form[] = Elm::input('link','视频链接地址')->col(18);
        $form[] = Elm::hidden('adminId',$this->adminId)->col(18);
        $form = Form::make_post_form($form, url('saveByLink')->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 添加
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
     * 电视剧剧集列表
     * @param $vid
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function item($vid)
    {
        if (!videoModel::be($vid,"vid")) return app("json")->fail("视频不存在");
        $this->assign(MiniVideoItem::lst($vid));
        return $this->fetch();
    }

    /**
     * 修改
     * @param string $id
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id="")
    {
        if (!$id) return app("json")->fail("标签id不能为空");
        $ainfo = videoModel::get($id);
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
            $res = videoModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = videoModel::update($data,['id'=>$id]);
        }
        return $res ? app("json")->success("操作成功",'code') : app("json")->fail("操作失败");
    }

    /**
     * 通过链接保存数据
     * @return mixed
     */
    public function saveByLink()
    {
        $data = Util::postMore([
            ['type',''],
            ['link',''],
            ['adminId','']
        ]);
        if ($data['type'] == "") return app("json")->fail("视频类型为空!");
        if ($data['link'] == "") return app("json")->fail("链接为空!");
        return videoModel::saveByLink($data) ? app("json")->success("操作成功",'code') : app("json")->fail("操作失败");
    }
}