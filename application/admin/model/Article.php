<?php
namespace app\admin\model;
use think\Model;

class Article extends Model
{
    //关联cate表
    public function cate()
    {
        return $this->belongsTo("Cate","cateid");
    }

}