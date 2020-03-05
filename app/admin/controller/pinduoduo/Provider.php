<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;

/**
 * 供应商信息
 * Class Provider
 * @package app\admin\controller\pinduoduo
 */
class Provider extends AuthController
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
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['app_name',''],
            ['developer_id',''],
            ['status',''],
            ['page',1],
            ['limit',20],
        ]);
        return Json::successlayui(pModel::systemPage($where));
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
        $form[] = Elm::input('developer_id','开发者id')->col(10);
        $form[] = Elm::input('app_name','应用名称')->col(10);
        $form[] = Elm::input('client_id','client_id')->col(10);
        $form[] = Elm::input('client_secret','client_secret')->col(10);
        $form[] = Elm::input('developer_name','开发者账号')->col(10);
        $form[] = Elm::input('developer_pwd','开发者密码')->col(10);
        $form[] = Elm::input('limit_num','限制数量')->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save')->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 修改账号
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id="")
    {
        if (!$id) return app("json")->fail("账号id不能为空");
        $pinfo = pModel::get($id);
        if (!$pinfo) return app("json")->fail("没有该账号");
        $form = array();
        $form[] = Elm::input('developer_id','开发者id',$pinfo['developer_id'])->col(10);
        $form[] = Elm::input('app_name','应用名称',$pinfo['app_name'])->col(10);
        $form[] = Elm::input('client_id','client_id',$pinfo['client_id'])->col(10);
        $form[] = Elm::input('client_secret','client_secret',$pinfo['client_secret'])->col(10);
        $form[] = Elm::input('developer_name','开发者账号',$pinfo['developer_name'])->col(10);
        $form[] = Elm::input('developer_pwd','开发者密码',$pinfo['developer_pwd'])->col(10);
        $form[] = Elm::input('limit_num','限制数量',$pinfo['limit_num'])->col(10);
        $form[] = Elm::radio('status','状态',$pinfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
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
            ['developer_id',''],
            ['app_name',''],
            ['client_id',''],
            ['client_secret',''],
            ['developer_name',''],
            ['developer_pwd',''],
            ['limit_num',5],
            ['status',1],
        ]);
        if ($data['developer_id'] == "") return app("json")->fail("开发者id不能为空");
        if ($data['app_name'] == "") return app("json")->fail("应用名称不能为空");
        if ($data['client_id'] == "") return app("json")->fail("client_id不能为空");
        if ($data['client_secret'] == "") return app("json")->fail("client_secret不能为空");
        if ($data['limit_num'] == "") return app("json")->fail("限制数量不能为空");
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
}