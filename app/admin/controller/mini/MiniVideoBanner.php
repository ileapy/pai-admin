<?php


namespace app\admin\controller\mini;


use app\admin\controller\AuthController;
use app\admin\model\mini\MiniVideoBanner as BModel;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\UtilService as Util;
use think\facade\Route as Url;

/**
 * 轮播
 * Class MiniVideoBanner
 * @package app\admin\controller\mini
 */
class MiniVideoBanner extends AuthController
{
    /**
     * 列表
     * @param Request $request
     * @return
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['name',''],
            ['status',''],
            ['page',1],
            ['limit',20],
        ]);
        return app("json")->layui(BModel::systemPage($where));
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
        $form[] = Elm::input('name','轮播标题')->col(10);
        $form[] = Elm::input('tinyname','轮播简介')->col(10);
        $form[] = Elm::frameImage('image','图片',Url::buildUrl('admin/widget.images/index',array('fodder'=>'image','limit'=>1)))->icon("ios-image")->width('96%')->height('440px')->col(10);
        $form[] = Elm::input('link','链接')->col(20);
        $form[] = Elm::number('rank','排序')->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save')->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 修改
     * @param string $id
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id="")
    {
        if (!$id) return app("json")->fail("视频id不能为空");
        $ainfo = BModel::get($id);
        if (!$ainfo) return app("json")->fail("没有该标签");
        $form = array();
        $form[] = Elm::input('name','轮播标题',$ainfo['name'])->col(10);
        $form[] = Elm::input('tinyname','轮播简介',$ainfo['tinyname'])->col(10);
        $form[] = Elm::frameImage('image','图片',Url::buildUrl('admin/widget.images/index',array('fodder'=>'image','limit'=>1)),$ainfo['image'])->icon("ios-image")->width('96%')->height('440px')->col(10);
        $form[] = Elm::input('link','链接',$ainfo['link'])->col(20);
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
            ['tinyname',''],
            ['image',''],
            ['link',''],
            ['rank',0],
            ['status',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("轮播名称不能为空");
        if ($data['tinyname'] == "") return app("json")->fail("轮播简介不能为空");
        if ($data['image'] == "") return app("json")->fail("图片不能为空");
        if (is_array($data['image'])) $data['image'] = $data['image'][0];
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = BModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = BModel::update($data,['id'=>$id]);
        }
        return $res ? app("json")->success("操作成功",'code') : app("json")->fail("操作失败");
    }
}