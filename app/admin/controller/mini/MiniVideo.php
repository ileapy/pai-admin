<?php


namespace app\admin\controller\mini;

use app\admin\controller\AuthController;
use app\admin\model\mini\MiniVideo as videoModel;
use app\admin\model\mini\MiniVideoItem;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\UtilService as Util;
use think\facade\Route as Url;

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
        $form[] = Elm::input('vid','视频ID')->col(10);
        $form[] = Elm::input('title','电影名称')->col(10);
        $form[] = Elm::input('tinyname','视频简要')->col(10);
        $form[] = Elm::select('type','标签类型')->options(function (){
            $menu[] = ['label'=>"电影",'value'=>"movie"];
            $menu[] = ['label'=>"电视剧",'value'=>"tv"];
            return $menu;
        })->col(10);
        $form[] = Elm::select('source','视频来源')->options(function (){
            $menu[] = ['label'=>"腾讯",'value'=>"qq"];
            $menu[] = ['label'=>"爱奇艺",'value'=>"iqiyi"];
            $menu[] = ['label'=>"优酷",'value'=>"youku"];
            return $menu;
        })->col(10);
        $form[] = Elm::input('time','上映时间')->col(10);
        $form[] = Elm::frameImage('image','首页封面',Url::buildUrl('admin/widget.images/index',array('fodder'=>'image','limit'=>1)))->icon("ios-image")->width('96%')->height('440px')->col(10);
        $form[] = Elm::frameImage('cover','商品封面',Url::buildUrl('admin/widget.images/index',array('fodder'=>'cover','limit'=>1)))->icon("ios-image")->width('96%')->height('440px')->col(10);
        $form[] = Elm::number('skip_sec','广告秒数',0)->min(0)->col(10);
        $form[] = Elm::number('fee','观看费用',0)->min(0)->col(10);
        $form[] = Elm::number('discount','折扣',0)->min(0)->col(10);
        $form[] = Elm::radio('recommend','是否推荐',0)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(10);
        $form[] = Elm::radio('love','猜你喜欢',0)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(10);
        $form[] = Elm::textarea('desc','简介')->col(20);
        $form[] = Elm::number('rank','排序',0)->col(10);
        $form[] = Elm::number('num','总集数',0)->min(0)->col(10);
        $form[] = Elm::number('now_num','更新至',0)->min(0)->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save',['is_add'=>1])->build());
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
     * @param string $vid
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($vid="")
    {
        if (!$vid) return app("json")->fail("视频id不能为空");
        $ainfo = videoModel::get(['vid'=>$vid]);
        if (!$ainfo) return app("json")->fail("没有该视频");
        $form = array();
        $form[] = Elm::input('vid','视频ID',$ainfo['vid'])->readonly(true)->col(10);
        $form[] = Elm::input('title','电影名称',$ainfo['title'])->col(10);
        $form[] = Elm::input('tinyname','视频简要',$ainfo['tinyname'])->col(10);
        $form[] = Elm::select('type','标签类型',$ainfo['type'])->options(function (){
            $menu[] = ['label'=>"电影",'value'=>"movie"];
            $menu[] = ['label'=>"电视剧",'value'=>"tv"];
            return $menu;
        })->col(10);
        $form[] = Elm::select('source','视频来源',$ainfo['source'])->options(function (){
            $menu[] = ['label'=>"腾讯",'value'=>"qq"];
            $menu[] = ['label'=>"爱奇艺",'value'=>"iqiyi"];
            $menu[] = ['label'=>"优酷",'value'=>"youku"];
            return $menu;
        })->col(10);
        $form[] = Elm::input('time','上映时间',$ainfo['time'])->col(10);
        $form[] = Elm::frameImage('image','首页封面',Url::buildUrl('admin/widget.images/index',array('fodder'=>'image','limit'=>1)),$ainfo['image'] ? (strpos($ainfo['image'],'http') == false ? $ainfo['image'] : 'http:'.$ainfo['image']) : '')->icon("ios-image")->width('96%')->height('440px')->col(10);
        $form[] = Elm::frameImage('cover','商品封面',Url::buildUrl('admin/widget.images/index',array('fodder'=>'cover','limit'=>1)),$ainfo['cover'] ? (strpos($ainfo['cover'],'http') == false ? $ainfo['cover'] : 'http:'.$ainfo['cover']) : '')->icon("ios-image")->width('96%')->height('440px')->col(10);
        $form[] = Elm::number('skip_sec','广告秒数',$ainfo['skip_sec'])->min(0)->col(10);
        $form[] = Elm::number('fee','观看费用',$ainfo['fee'])->min(0)->col(10);
        $form[] = Elm::number('discount','折扣',$ainfo['discount'])->min(0)->col(10);
        $form[] = Elm::radio('recommend','是否推荐',$ainfo['recommend'])->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(10);
        $form[] = Elm::radio('love','猜你喜欢',$ainfo['love'])->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(10);
        $form[] = Elm::textarea('desc','简介',$ainfo['desc'])->col(20);
        $form[] = Elm::number('rank','排序',$ainfo['rank'])->col(10);
        if ($ainfo['type'] == 'tv')
        {
            $form[] = Elm::number('num','总集数',$ainfo['num'])->min(0)->col(10);
            $form[] = Elm::number('now_num','更新至',$ainfo['now_num'])->min(0)->col(10);
        }
        $form[] = Elm::radio('status','状态',$ainfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save',['is_add'=>0])->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 保存修改
     * @param string $is_add
     * @return mixed
     */
    public function save($is_add = 1)
    {
        $data = Util::postMore([
            ['title',''],
            ['tinyname',''],
            ['type',''],
            ['vid',''],
            ['source',''],
            ['time',''],
            ['image',''],
            ['cover',''],
            ['skip_sec',''],
            ['fee',''],
            ['discount',0],
            ['recommend',1],
            ['love',1],
            ['desc',''],
            ['now_num',0],
            ['num',0],
            ['desc',''],
            ['rank',''],
            ['status',0]
        ]);
        if ($data['vid'] == "") return app("json")->fail("视频Id不能为空");
        if ($data['title'] == "") return app("json")->fail("视频名称不能为空");
        if ($data['type'] == "") return app("json")->fail("视频类型不能为空");
        if ($is_add)
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = videoModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = videoModel::update($data,['vid'=>$data['vid']]);
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

    /**
     * 删除操作
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function del(Request $request)
    {
        $ids = $request->param("vid",0);
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，视频Id为空！");
        if (!is_array($ids)) $ids = explode(",",$ids);
        return videoModel::where('vid',"in",$ids)->delete() ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 启用
     * @param Request $request
     * @return
     */
    public function enabled(Request $request)
    {
        $ids = $request->param("vid",0);
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，视频Id为空！");
        if (!is_array($ids)) $ids = explode(",",$ids);
        return videoModel::where('vid',"in",$ids)->update(['status'=>1]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 禁用
     * @param Request $request
     * @return
     */
    public function disabled(Request $request)
    {
        $ids = $request->param("vid",0);
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，视频Id为空！");
        if (!is_array($ids)) $ids = explode(",",$ids);
        return videoModel::where('vid',"in",$ids)->update(['status'=>0]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}