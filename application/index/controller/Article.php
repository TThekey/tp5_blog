<?php
namespace app\index\controller;
use app\index\controller\Base;

class Article  extends Base
{
    public function index()
    {
        $arid = input("arid");
        $articles = db("article")->find($arid);
        db("article")->where("id","=",$arid)->setInc("click","1"); //点击量+1
        $Cates = db("cate")->find($articles["cateid"]);
        $res = db("article")->where(array("cateid"=>$Cates['id'],"state"=>1))->limit(8)->select();

        $this->assign(
            array(
            "articles" => $articles,
            "Cates"    => $Cates,
            "res"      =>$res,
        ));
        return view("article");
    }
}
