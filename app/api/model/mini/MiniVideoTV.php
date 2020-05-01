<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

class MiniVideoTV extends BaseModel
{
    use ModelTrait;

    /**
     * 查询标签
     * @param string $vid
     */
    public static function tags(string $vid)
    {
        $model = new self;
        $model = $model->withJoin("tag");
        $model = $model->where("vid",$vid);
        return $model->column("tag.name");
    }

    /**
     * 关联标签
     * @return \think\model\relation\HasOne
     */
    public function tag()
    {
        return $this->hasOne(MiniVideoTag::class,"id","tid");
    }
}