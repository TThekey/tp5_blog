<?php
namespace app\index\controller;
use app\index\controller\Base;

class Cate  extends Base
{
    public function index()
    {
        $id = input("cateid");
        $Cates = db("cate")->find($id);
        $this->assign("Cates",$Cates);

        $articles = db("article")->where(array("cateid"=>$id))->paginate(3);
        $this->assign("articles",$articles);
        return view("cate");
    }
}
