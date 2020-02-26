<?php


namespace app\admin\controller\project;


use app\admin\controller\AuthController;
use app\admin\model\admin\Admin as aModel;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\UtilService as Util;
use learn\services\JsonService as Json;
use app\admin\model\project\project as pModel;

/**
 * 项目管理
 * Class project
 * @package app\admin\controller\project
 */
class project extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 列表
     * @param Request $request
     * @return mixed
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',20],
        ]);
        return Json::successlayui(pModel::lst($where));
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
        $form[] = Elm::input('name','项目名称')->col(10);
        $form[] = Elm::select('manager','项目负责人')->options(function(){
            $list = aModel::lst();
            $menus=[];
            foreach ($list as $menu){
                $menus[] = ['value'=>$menu['id'],'label'=>$menu['id']." - ".$menu['realname']];//,'disabled'=>$menu['pid']== 0];
            }
            return $menus;
        })->col(10);
        $form[] = Elm::textarea('intro','项目简介')->col(24);
        $form[] = Elm::select('language','编程语言')->options(function (){
            return languageOptions();
        })->multiple(true)->col(10);
        $form[] = Elm::dateTimeRange('start_time','开始时间')->col(10);
        $form[] = Elm::input('sql_ip','数据库IP')->col(10);
        $form[] = Elm::input('sql_name','数据库账号')->col(10);
        $form[] = Elm::password('sql_password','数据库密码')->col(10);
        $form[] = Elm::textarea('remark','项目备注')->col(24);
        $form[] = Elm::radio('status','状态',0)->options([['label'=>'未开始','value'=>0],['label'=>'进行中','value'=>1],['label'=>'已完成','value'=>2],['label'=>'维护中','value'=>3],['label'=>'以终止','value'=>4]])->col(24);
        return Form::make_post_form($form, url('save')->build());
    }

    /**
     * 修改
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id='')
    {
        if (!$id) return app("json")->fail("项目id不能为空");
        $info = pModel::get($id);
        if (!$info) return app("json")->fail("没有该项目");
        $form = array();
        $form[] = Elm::input('name','项目名称',$info['name'])->col(10);
        $form[] = Elm::select('manager','项目负责人',$info['manager'])->options(function(){
            $list = aModel::lst();
            $menus=[];
            foreach ($list as $menu){
                $menus[] = ['value'=>$menu['id'],'label'=>$menu['id']." - ".$menu['realname']];//,'disabled'=>$menu['pid']== 0];
            }
            return $menus;
        })->col(10);
        $form[] = Elm::textarea('intro','项目简介',$info['intro'])->col(24);
        $form[] = Elm::select('language','编程语言',explode(",",$info['language']))->options(function (){
            return languageOptions();
        })->multiple(true)->col(10);
        $form[] = Elm::dateTimeRange('start_time','开始时间',$info['start_time'],$info['end_time'])->col(10);
        $form[] = Elm::input('sql_ip','数据库IP',$info['sql_ip'])->col(10);
        $form[] = Elm::input('sql_name','数据库账号',$info['sql_name'])->col(10);
        $form[] = Elm::password('sql_password','数据库密码',$info['sql_password'])->col(10);
        $form[] = Elm::textarea('remark','项目备注',$info['remark'])->col(24);
        $form[] = Elm::radio('status','状态',$info['status'])->options([['label'=>'未开始','value'=>0],['label'=>'进行中','value'=>1],['label'=>'已完成','value'=>2],['label'=>'维护中','value'=>3],['label'=>'以终止','value'=>4]])->col(24);
        return Form::make_post_form($form, url('save',["id"=>$id])->build());
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
            ['manager',''],
            ['intro',''],
            ['language',''],
            ['start_time',''],
            ['sql_ip',''],
            ['sql_name',''],
            ['sql_password',''],
            ['remark',''],
            ['status','']
        ]);
        if ($data['name'] == "") return app("json")->fail("项目名称不能为空");
        if ($data['manager'] == "") return app("json")->fail("项目管理员不能为空");
        if ($data['start_time'] == "") return app("json")->fail("项目起始时间不能为空");
        $data['end_time'] = $data['start_time'][1];
        $data['start_time'] = $data['start_time'][0];
        if (!empty($data['language'])) $data['language'] = implode(",",$data['language']);
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = pModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = pModel::update($data,['id'=>$id]);
        }
        return $res ? Json::success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 删除
     * @param $id
     * @return
     */
    public function del($id)
    {
        if (!$id) return app("json")->fail("参数有误，Id为空！");
        return pModel::del($id) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}