<?php
namespace app\index\controller;
use app\index\controller\Base;

class Search  extends Base
{
    public function index()
    {
       $keywords = input("keywords");
        if($keywords){
            $map["title"] = array('like','%'.$keywords.'%');
            $searchs = db("article")->where($map)->order("id desc")->paginate($listRows = 3,$simple = false,$config = [
                'query'=>array('keywords'=>$keywords),
            ]);
            $this->assign(array(
                "searchs"=>$searchs,
                "keywords"=>$keywords,
            ));
        }
        else{
            $this->assign(array(
               "searchs"=>null,
                "keywords"=>"暂无关键词"
            ));
        }
        return view("search");
    }

}
