<?php


namespace app\admin\controller\wechat;

use app\admin\controller\AuthController;
use app\admin\model\wechat\WechatMedia;
use app\admin\model\wechat\WechatNewsList;
use app\Request;
use EasyWeChat\Kernel\Messages\Article;
use learn\services\UtilService as Util;
use app\admin\model\wechat\WechatNews as nModel;
use learn\services\WechatService;

/**
 * 图文管理
 * Class WechatNews
 * @package app\admin\controller\wechat
 */
class WechatNews extends AuthController
{
    /**
     * 列表
     * @return string
     * @throws \think\db\exception\DbException
     */
    public function index()
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',12],
        ]);
        $this->assign("item",WechatNewsList::system($where));
        return $this->fetch();
    }

    /**
     * 更新图文
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sync()
    {
        return nModel::sync() ? app("json")->success("更新成功") : app("json")->fail("更新出错");
    }

    /**
     * 添加
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function add($id = 0)
    {
        $data = [];
        if ($id) $data = WechatNewsList::getAllItem($id);
        if ($id == 0 || empty($data)) $data = [['title'=>'标题','thumb_url'=>'']];
        $this->assign("id",$id);
        $this->assign("data",$data);
        return $this->fetch();
    }

    /**
     * 保存
     * @param Request $request
     * @return
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function save(Request $request)
    {
        $data = Util::postMore([
           ['id',0],
           ['data',[]]
        ]);
        $material = WechatService::materialService();
        if ($data['id'] == 0) // 新增
        {
            $articles = [];
            $ids = [];
            foreach ($data['data'] as $v)
            {
                $thumb_media_id = WechatMedia::getMediaIdByPath($v['thumb_url']);
                $article = new Article([
                    'title' => $v['title'],
                    'thumb_media_id' => $thumb_media_id,
                    'author' =>$v['author'],
                    'digest' => $v['digest'],
                    'show_cover' => 0,
                    'content' => $v['content'],
                    'content_source_url' => '',
                ]);
                $ids[] = nModel::insertGetId([
                    'title' => $v['title'],
                    'thumb_media_id' => $thumb_media_id,
                    'author' =>$v['author'],
                    'digest' => $v['digest'],
                    'show_cover_pic' => 0,
                    'content' => $v['content'],
                    'content_source_url' => '',
                    'thumb_url' => $v['thumb_url'],
                    'url' => '',
                    'create_user'=>$this->adminId,
                    'create_time' => time()
                ]);
                $articles[] = $article;
            }
            $res = $material->uploadArticle($articles);
            return WechatNewsList::insert([
                'media_id'=>$res['media_id'],
                'item' => implode(",",$ids),
                'content' => json_encode($articles,true),
                'create_time' => time(),
                'update_time' => time()
            ]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
        }
        else{  // 修改
            foreach ($data['data'] as $v)
            {
                $thumb_media_id = WechatMedia::getMediaIdByPath($v['thumb_url']);
                $article = new Article([
                    'title' => $v['title'],
                    'thumb_media_id' => $thumb_media_id,
                    'author' =>$v['author'],
                    'digest' => $v['digest'],
                    'show_cover' => 0,
                    'content' => $v['content'],
                    'content_source_url' => '',
                ]);
                $ids[] = nModel::insertGetId([
                    'title' => $v['title'],
                    'thumb_media_id' => $thumb_media_id,
                    'author' =>$v['author'],
                    'digest' => $v['digest'],
                    'show_cover_pic' => 0,
                    'content' => $v['content'],
                    'content_source_url' => '',
                    'thumb_url' => $v['thumb_url'],
                    'url' => '',
                    'create_user'=>$this->adminId,
                    'create_time' => time()
                ]);
                $articles[] = $article;
            }
        }
    }

    /**
     * 删除
     * @param $id
     * @return mixed|void
     */
    public function del($id = 0)
    {
        if (!$id) return app("json")->fail("文章ID为空！");
        return nModel::del2($this->request->param("id")) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}