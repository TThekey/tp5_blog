<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\controller\Base;

class Article  extends Base
{
    public function lst()
    {
        $list = ArticleModel::paginate(3);
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $date=[
                "title"=>input("title"),
                 "author"=>input("author"),
                 "desc"=>input("desc"),
                "keywords"=>str_replace("，",",",input("keywords")),
                "content"=>input("content"),
                "cateid"=>input("cateid"),
                "time"=>time(),
            ];

            if(input("state")=="on"){
                $date["state"]=1;
            }

            if($_FILES["pic"]["tmp_name"]){
                $file = request()->file("pic");
                $info = $file->move(ROOT_PATH."public".DS."static/uploads");
                $date["pic"] = $info->getSaveName();
            }

           $validate = validate("Article");

            if(!$validate->scene("add")->check($date)){
                $this->error($validate->getError());
            }

            $request = db("article")->insert($date);
            if($request){
                return $this->success("添加文章成功","lst");

            }else{
                return $this->error("添加文章失败");
            }

            return;
        }

        $cates = db("cate")->select();
        $this->assign("cates",$cates);
        return $this->fetch();
    }

    public function edit(){

        $id = input("id");
        $articles = db("article")->find($id);

        if(request()->isPost()){
            $data =[
                "id" => input("id"),
                "title"=>input("title"),
                "author"=>input("author"),
                "desc"=>input("desc"),
                "keywords"=>str_replace("，",",",input("keywords")),
                "content"=>input("content"),
                "cateid"=>input("cateid"),
            ];

            if(input("state")=="on"){
                $data["state"]=1;
            }else{
                $data["state"]=0;
            }

            if($_FILES["pic"]["tmp_name"]){
                $file = request()->file("pic");
                $info = $file->move(ROOT_PATH."public".DS."static/uploads");
                $data["pic"] = $info->getSaveName();
            }

            $validate = validate("Article");

            if(!$validate->scene("edit")->check($data)){
                $this->error($validate->getError());

            }

            $request = db("article")->update($data);
            if($request){
                return $this->success("修改文章成功","lst");

            }else{
                return $this->error("修改文章失败");
            }

            return;
        }


        $this->assign("articles",$articles);
        $cates = db("cate")->select();
        $this->assign("cates",$cates);

        return $this->fetch();
    }

    public function del(){
        $id = input("id");
        $request = db("article")->delete($id);
            if($request){
                $this->success("删除文章成功","lst");
            }else{
                $this->error("删除文章失败");
            }

    }



}