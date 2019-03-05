<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Base  extends Controller
{
    public function _initialize()
    {
        $this->right();
        $cates = Db::name("cate")->order("id asc")->select();
        $tagres = db("tag")->order("id desc")->select();
        $this->assign(array(
            "cates"=>$cates,
            "tagres"=>$tagres,
        ));
    }

    public function right(){
        $click = Db("article")->order("click desc")->limit(4)->select();
        $tj = Db("article")->where("state" ,"=",1)->order("click desc")->limit(4)->select();
        $this->assign("click",$click);
        $this->assign("tj",$tj);
    }
}
