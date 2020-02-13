<?php


namespace app\admin\controller\widget;


use app\admin\controller\AuthController;

class Files extends AuthController
{
    /**
     * 单个图片上传
     * @return mixed
     */
    public function image()
    {
        $savename = \think\facade\Filesystem::putFile( 'image', request()->file('file'));
        return $savename ? app("json")->success("上传成功",$savename) : app("json")->fail("上传失败");
    }
}