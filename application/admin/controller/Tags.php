<?php
namespace app\admin\controller;
use app\admin\controller\Base;

class Tags  extends Base
{
    public function lst()
    {
        $list = db("tag")->paginate(3);
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $date=[
                "tagname"=>input("tagname"),
            ];

           $validate = validate("Tags");

            if(!$validate->scene("add")->check($date)){
                $this->error($validate->getError());
            }

            $request = db("tag")->insert($date);
            if($request){
                return $this->success("添加标签成功","lst");

            }else{
                return $this->error("添加标签失败");
            }

            return;
        }

        return $this->fetch();
    }

    public function edit(){

        $id = input("id");
        $tags = db("tag")->find($id);

        if(request()->isPost()){
            $date=[
                "id"=>input("id"),
                "tagname"=>input("tagname"),
            ];


            $validate = validate("Tags");

            if(!$validate->scene("edit")->check($date)){
                $this->error($validate->getError());

            }

            $request = db("tag")->update($date);
            if($request){
                return $this->success("修改标签成功","lst");

            }else{
                return $this->error("修改标签失败");
            }

            return;
        }


        $this->assign("tags",$tags);

        return $this->fetch();
    }

    public function del(){
        $id = input("id");
        $request = db("tag")->delete($id);
            if($request){
                $this->success("删除标签成功","lst");
            }else{
                $this->error("删除标签失败");
            }

    }



}