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
     * 权限列表
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        return app("json")->layui(RModel::systemPage());
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
        return RModel::saveReply($data) ? app("json")->success("操作成功",true) : app("json")->fail("操作失败");
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
        return compact("type","content");
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