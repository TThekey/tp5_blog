<?php
namespace app\index\controller;
use app\index\controller\Base;

class Article  extends Base
{
    public function index()
    {
        $arid = input("arid");
        $articles = db("article")->find($arid);
//        $relats = $this->relat($articles['keywords']);
        db("article")->where("id","=",$arid)->setInc("click","1");
        $Cates = db("cate")->find($articles["cateid"]);
        $res = db("article")->where(array("cateid"=>$Cates['id'],"state"=>1))->limit(8)->select();

        $this->assign(array(
            "articles" => $articles,
            "Cates"    => $Cates,
            "res"      =>$res,
//          "relats"   =>$relats,
        ));
        return $this->fetch("article");
    }

//    public function relat($keywords){
//        $arr = explode(",",$keywords);
//        static $relats = array();
//        foreach ($arr as $k=>$v){
//            $map["keywords"] = array('like','%'.$v.'%');
//            $art = db("article")->where($map)->order("id desc")->limit(8)->select();
//            $relats = array_merge("$art","$relats");
//        }
//        return $relats;
//    }


}
