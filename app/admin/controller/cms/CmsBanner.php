<?php


namespace app\admin\controller\cms;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\UtilService as Util;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use app\admin\model\cms\CmsBanner as BModel;
use think\facade\Route as Url;

class CmsBanner extends AuthController
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
        $form[] = Elm::number('position','位置')->col(10);
        $form[] = Elm::frameImage('image','图片',Url::buildUrl('admin/widget.images/index',array('fodder'=>'image','limit'=>1)))->icon("ios-image")->width('96%')->height('390px')->col(10);
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
        if (!$id) return app("json")->fail("标签id不能为空");
        $ainfo = BModel::get($id);
        if (!$ainfo) return app("json")->fail("没有该标签");
        $form = array();
        $form[] = Elm::input('name','轮播标题',$ainfo['name'])->col(10);
        $form[] = Elm::number('position','位置',$ainfo['position'])->col(10);
        $form[] = Elm::uploadImage('image','图片',url('/admin/widget.files/image'),$ainfo['image'])->limit(1)->multiple(false)->col(10);
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
            ['position',0],
            ['image',''],
            ['link',''],
            ['rank',0],
            ['status',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("轮播名称不能为空");
        if ($data['position'] == "") return app("json")->fail("轮播位置不能为空");
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