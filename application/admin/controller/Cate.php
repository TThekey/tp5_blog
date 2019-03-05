<?php
namespace app\admin\controller;
use app\admin\model\Cate as CateModel;
use app\admin\controller\Base;

class Cate  extends Base
{
    public function lst()
    {
        $list = CateModel::paginate(3);
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
            $date=[
              "catename"=>input("catename"),
            ];

           $validate = validate("Cate");

            if(!$validate->scene("add")->check($date)){
                $this->error($validate->getError());

            }

            $request = db("cate")->insert($date);
            if($request){
                return $this->success("添加栏目成功","lst");

            }else{
                return $this->error("添加栏目失败");
            }

            return;
        }

        return $this->fetch();
    }

    public function edit(){

        $id = input("id");
        $cates = db("cate")->find($id);

        if(request()->isPost()){
            $data =[
                 "id" => input("id"),
                "catename"=>input("catename"),
            ];

            $validate = validate("Cate");
            if(!$validate->scene("edit")->check($data)){
                $this->error($validate->getError());
            }

            $request = db("cate")->update($data);
            if($request){
                return $this->success("修改栏目成功","lst");

            }else{
                return $this->error("修改栏目失败");
            }

            return;
        }


        $this->assign("cates",$cates);

        return $this->fetch();
    }

    public function del(){
        $id = input("id");
            $request = db("cate")->delete($id);
            if($request){
                $this->success("删除栏目成功","lst");
            }else{
                $this->error("删除栏目失败");
            }

    }




}