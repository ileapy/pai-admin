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
        $savename = (new \think\facade\Filesystem)->putFile( 'image', request()->file('image'));
        return $savename ? app("json")->success("上传成功") : app("json")->fail("上传失败");
    }
}