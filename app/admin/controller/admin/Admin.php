<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;
use app\admin\model\admin\Admin as aModel;
use app\admin\model\admin\AdminRole as rModel;
use app\Request;
use learn\services\UtilService as Util;
use learn\services\JsonService as Json;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;

/**
 * 账号管理
 * Class Admin
 * @package app\admin\controller\admin
 */
class Admin extends AuthController
{
    /**
     * 账号列表
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        $this->assign("auths",rModel::getAuthLst());
        return $this->fetch();
    }

    /**
     * 账号列表
     * @param Request $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['name',''],
            ['role_id',''],
            ['status',''],
            ['page',1],
            ['limit',20],
        ]);
        return Json::successlayui(aModel::systemPage($where));
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
        $form[] = Elm::input('name','登录账号')->col(10);
        $form[] = Elm::input('nickname','昵称')->col(10);
        $form[] = Elm::frameImage('avatar','头像',url('/admin/widget.files/image'))->col(10);
        $form[] = Elm::password('pwd','密码')->col(10);
        $form[] = Elm::input('realname','真实姓名')->col(10);
        $form[] = Elm::select('role_id','角色')->options(function(){
            $list = rModel::getAuthLst();
            $menus=[];
            foreach ($list as $menu){
                $menus[] = ['value'=>$menu['id'],'label'=>$menu['name']];//,'disabled'=>$menu['pid']== 0];
            }
            return $menus;
        })->col(10);
        $form[] = Elm::input('tel','电话')->col(10);
        $form[] = Elm::email('mail','邮箱')->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
        return Form::make_post_form($form, url('save')->build());
    }

    /**
     * 修改账号
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id="")
    {
        if (!$id) return app("json")->fail("账号id不能为空");
        $ainfo = aModel::get($id);
        if (!$ainfo) return app("json")->fail("没有该账号");
        $form = array();
        $form[] = Elm::input('name','登录账号',$ainfo['name'])->col(10);
        $form[] = Elm::input('nickname','昵称',$ainfo['nickname'])->col(10);
        $form[] = Elm::uploadImage('avatar','头像',url('/admin/widget.files/image'),$ainfo['avatar'])->col(10);
        $form[] = Elm::password('pwd','密码',$ainfo['pwd'])->col(10);
        $form[] = Elm::input('realname','真实姓名',$ainfo['realname'])->col(10);
        $form[] = Elm::select('role_id','角色',$ainfo['role_id'])->options(function(){
            $list = rModel::getAuthLst();
            $menus=[];
            foreach ($list as $menu){
                $menus[] = ['value'=>$menu['id'],'label'=>$menu['name']];//,'disabled'=>$menu['pid']== 0];
            }
            return $menus;
        })->col(10);
        $form[] = Elm::input('tel','电话',$ainfo['tel'])->col(10);
        $form[] = Elm::email('mail','邮箱',$ainfo['mail'])->col(10);
        $form[] = Elm::radio('status','状态',$ainfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
        return Form::make_post_form($form, url('save',['id'=>$id])->build());
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
            ['nickname',''],
            ['avatar',''],
            ['pwd',''],
            ['realname',''],
            ['role_id',''],
            ['tel',''],
            ['mail',''],
            ['status','']
        ]);
        if ($data['name'] == "") return app("json")->fail("登录账号不能为空");
        if ($data['pwd'] == "") return app("json")->fail("密码不能为空");
        if ($data['tel'] == "") return app("json")->fail("手机号不能为空");
        if ($data['mail'] == "") return app("json")->fail("邮箱不能为空");
        if ($id=="")
        {
            $data['pwd'] = md5(md5($data['pwd']));
            $data['ip'] = $this->request->ip();
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = aModel::insert($data);
        }else
        {
            $ainfo = aModel::get($id);
            if ($ainfo['pwd'] != $data['pwd']) $data['pwd'] = md5(md5($data['pwd']));
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = aModel::update($data,['id'=>$id]);
        }
        return $res ? Json::success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 删除账号
     * @param $id
     * @return
     */
    public function del($id)
    {
        if (!$id) return app("json")->fail("参数有误，Id为空！");
        return aModel::del($id) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}