<?php
namespace app\admin\controller;
use app\admin\model\Links as LinksModel;
use app\admin\controller\Base;

class Links  extends Base
{
    public function lst()
    {
        $list = LinksModel::paginate(3);
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $date=[
                "title"=>input("title"),
                 "url"=>(input("url")),
                 "desc"=>(input("desc")),
            ];

           $validate = validate("Links");

            if(!$validate->scene("add")->check($date)){
                $this->error($validate->getError());
            }

            $request = db("links")->insert($date);
            if($request){
                return $this->success("添加链接成功","lst");

            }else{
                return $this->error("添加链接失败");
            }

            return;
        }

        return $this->fetch();
    }

    public function edit(){

        $id = input("id");
        $links = db("links")->find($id);

        if(request()->isPost()){
            $data =[
                "id" => input("id"),
                "title" => input("title"),
                "url" => input("url"),
                "desc" => input("desc"),
            ];


            $validate = validate("Links");

            if(!$validate->scene("edit")->check($data)){
                $this->error($validate->getError());

            }

            $request = db("links")->update($data);
            if($request){
                return $this->success("修改链接成功","lst");

            }else{
                return $this->error("修改链接失败");
            }

            return;
        }


        $this->assign("links",$links);

        return $this->fetch();
    }

    public function del(){
        $id = input("id");
        $request = db("links")->delete($id);
            if($request){
                $this->success("删除链接成功","lst");
            }else{
                $this->error("删除链接失败");
            }

    }



}