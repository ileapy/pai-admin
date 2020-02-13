<?php


namespace app\admin\controller\widget;


use app\admin\controller\AuthController;
use learn\services\JsonService as Json;

class Files extends AuthController
{
    /**
     * 单个图片上传
     * @return mixed
     */
    public function image()
    {
        $savename = \think\facade\Filesystem::putFile( 'image', request()->file('file'));
        return $savename ? Json::success("上传成功",['filePath'=>"/upload/".$savename,"name"=>$savename]) : app("json")->fail("上传失败");
    }
}