<?php

namespace app\admin\controller\mini;


use app\admin\controller\AuthController;
use app\admin\model\mini\MiniVideoItem as itemModel;
use app\Request;
use learn\services\UtilService as Util;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use think\facade\Route as Url;

/**
 * Class MiniVideoItem
 * @package app\admin\controller\mini
 */
class MiniVideoItem extends AuthController
{
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
            ['vid',''],
            ['name',''],
            ['status',''],
            ['page',1],
            ['limit',20]
        ]);
        if ($where['vid'] == '') return app("json")->fail("视频ID为空！");
        return app("json")->layui(itemModel::systemPage($where));
    }

    /**
     * 删除操作
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function del(Request $request)
    {
        $ids = $request->param("xid",0);
        $vid = $request->param("vid",0);
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，剧集Id为空！");
        if (empty($vid) || !$vid) return app("json")->fail("参数有误，视频Id为空！");
        if (!is_array($ids)) $ids = explode(",",$ids);
        return itemModel::where('xid',"in",$ids)->where("vid",$vid)->delete() ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 启用
     * @param Request $request
     * @return mixed
     */
    public function enabled(Request $request)
    {
        $ids = $request->param("xid",0);
        $vid = $request->param("vid",0);
        if (empty($vid) || !$vid) return app("json")->fail("参数有误，视频Id为空！");
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，剧集Id为空！");
        if (!is_array($ids)) $ids = explode(",",$ids);
        return itemModel::where('xid',"in",$ids)->where("vid",$vid)->update(['status'=>1]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 禁用
     * @param Request $request
     * @return mixed
     */
    public function disabled(Request $request)
    {
        $ids = $request->param("xid",0);
        $vid = $request->param("vid",0);
        if (empty($vid) || !$vid) return app("json")->fail("参数有误，视频Id为空！");
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，剧集Id为空！");
        if (!is_array($ids)) $ids = explode(",",$ids);
        return itemModel::where('xid',"in",$ids)->where("vid",$vid)->update(['status'=>0]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
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
        $form[] = Elm::hidden('vid',$request->param("vid"));
        $form[] = Elm::input('xid','剧集ID')->col(10);
        $form[] = Elm::input('name','集数')->col(10);
        $form[] = Elm::number('skip_sec','跳过时间')->min(0)->col(10);
        $form[] = Elm::number('fee','费用')->min(0)->col(10);
        $form[] = Elm::number('rank','排序',0)->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save',['is_add'=>1])->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 修改
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit(Request $request)
    {
        if (!$request->param('vid')) return app("json")->fail("视频id不能为空");
        if (!$request->param('xid')) return app("json")->fail("剧集id不能为空");
        $ainfo = itemModel::get(['vid'=>$request->param('vid'),'xid'=>$request->param('xid')]);
        if (!$ainfo) return app("json")->fail("没有该视频");
        $form = array();
        $form[] = Elm::hidden('vid',$request->param("vid"));
        $form[] = Elm::hidden('xid',$request->param("xid"));
        $form[] = Elm::input('name','集数',$ainfo['name'])->col(10);
        $form[] = Elm::number('skip_sec','跳过时间',$ainfo['skip_sec'])->min(0)->col(10);
        $form[] = Elm::number('fee','费用',$ainfo['fee'])->min(0)->col(10);
        $form[] = Elm::number('rank','排序',$ainfo['rank'])->col(10);
        $form[] = Elm::radio('status','状态',$ainfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save',['is_add'=>0])->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 保存修改
     * @param int $is_add
     * @return mixed
     */
    public function save($is_add = 1)
    {
        $data = Util::postMore([
            ['name',''],
            ['vid',''],
            ['xid',''],
            ['skip_sec',''],
            ['fee',''],
            ['rank',''],
            ['status',0]
        ]);
        if ($data['vid'] == "") return app("json")->fail("视频Id不能为空");
        if ($data['xid'] == "") return app("json")->fail("剧集ID不能为空");
        if ($data['name'] == "") return app("json")->fail("集数不能为空");
        if ($is_add)
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = itemModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = itemModel::update($data,['vid'=>$data['vid'],'xid'=>$data['xid']]);
        }
        return $res ? app("json")->success("操作成功",'code') : app("json")->fail("操作失败");
    }
}