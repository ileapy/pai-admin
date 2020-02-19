<?php


namespace app\admin\controller\widget;


use app\admin\controller\AuthController;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;

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

    /**
     * base64转image
     * @return mixed
     */
    public function baseToImage()
    {
        $data = Util::postMore([
            ['image','']
        ]);
        if ($data['image'] == '') return app("json")->fail("上传失败,没有文件");
        $path = "upload/image/".date("Ymd").'/';
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data['image'], $result)){
            $type = $result[2];
            if(!file_exists($path)) mkdir($path, 0755,true);
            $savename = $path.md5(time()).".{$type}";
            if (file_put_contents($savename, base64_decode(str_replace($result[1], '', $data['image'])))) return app("json")->success("上传成功",['src'=>"/".$savename]);
            else return app("json")->fail("上传失败，写入文件失败！");
        }else return app("json")->fail("上传失败,图片格式有误！");
    }
}