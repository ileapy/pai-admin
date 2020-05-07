<?php


namespace app\admin\controller\widget;


use app\admin\controller\AuthController;
use app\admin\model\widget\Attachment;
use learn\services\storage\QcloudCoService;
use learn\services\UtilService as Util;
use think\facade\Filesystem;

class Files extends AuthController
{
    /**
     * 单个图片上传
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function image()
    {
        $file = $this->request->file("file");
        switch (systemConfig("storage_type"))
        {
            case 1:
                $savename = Filesystem::putFile( 'image', $file);
                $filePath = "/upload/".$savename;
                break;
            case 2:
                $savename = Filesystem::putFile( 'image', $file);
                $ext = $file->getOriginalExtension();
                $key = '/image/'.date('Ymd')."/".substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
                $filePath = QcloudCoService::put($key, $file->getRealPath());
                break;
        }
        return Attachment::addAttachment($this->request->param("cid"),$savename,$filePath,'image',$file->getMime(),$file->getSize(),systemConfig("storage_type")) ? app("json")->code()->success("上传成功",['filePath'=>$filePath,"name"=>$savename]) : app("json")->fail("上传失败");
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

    /**
     * tinymec
     * @return mixed
     */
    public function tinymce()
    {
        $savename = Filesystem::putFile( 'image', request()->file('file'));
        return json_encode(['location'=>"/upload/".$savename]);
    }

    /**
     * 上传多图片
     * @return mixed
     */
    public function images()
    {
        return Filesystem::putFile( 'image', request()->file('file')) ? app("json")->code()->success("上传成功") : app("json")->fail("上传失败");
    }

    /**
     * 证书上传
     * @return mixed
     */
    public function cert()
    {
        $file = $this->request->file("file");
        $savename = Filesystem::putFile( 'file', $file);
        $filePath = "/upload/".$savename;
        return $savename ? app("json")->code()->success("上传成功",['filePath'=>$filePath,"name"=>$savename]) : app("json")->fail("上传失败");
    }

    /**
     * 上传文件到cid:0,
     * 图片 视频 音频
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function file()
    {
        $file = $this->request->file("file");
        $type = getFileType($file->getMime());
        switch (systemConfig("storage_type"))
        {
            case 1:
                $savename = Filesystem::putFile($type, $file);
                $filePath = "/upload/".$savename;
                break;
            case 2:
                $savename = Filesystem::putFile($type, $file);
                $ext = $file->getOriginalExtension();
                $key = '/'.$type.'/'.date('Ymd')."/".substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
                $filePath = QcloudCoService::put($key, $file->getRealPath());
                break;
        }
        return Attachment::addAttachment(0,$savename,$filePath,$type,$file->getMime(),$file->getSize(),systemConfig("storage_type")) ? app("json")->code()->success("上传成功",['filePath'=>$filePath,"name"=>$savename]) : app("json")->fail("上传失败");
    }
}