<?php
namespace app\admin\controller;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\controller\Base;

class AuthGroup  extends Base
{
    public function lst()
    {
        $authGroupres = AuthGroupModel::paginate(2);
        $this->assign("authGroupres",$authGroupres);
        return view();
    }

    public function add()
    {
        if(request()->isPost()){
            $data = input("post.");
            if($data['rules']){
                $data['rules'] = implode(",",$data['rules']);
            }
            if(input("status")=="on"){
                $data["status"]=1;
            }else{
                $data["status"]=0;
            }

            $add = db('auth_group')->insert($data);
            if($add){
                $this->success("添加用户组成功","lst");
            }else{
                $this->error("添加用户组失败");
            }
            return;
        }

        $authrule = new AuthRuleModel();
        $authrules = $authrule->authRuleTree();
        $this->assign("authrules",$authrules);
        return view();
    }

    public function edit(){
        $id = input("id");
        $authGroups = db("auth_group")->find($id);

        if(request()->isPost()){
            $data = input("post.");
            if($data['rules']){
                $data['rules'] = implode(",",$data['rules']);
            }
            if(input("status")=="on"){
                $data["status"]=1;
            }else{
                $data["status"]=0;
            }

            $save = db('auth_group')->update($data);
            if($save){
                $this->success("修改用户组成功","lst");
            }else{
                $this->error("修改用户组失败");
            }
            return;
        }

        $this->assign("authGroups",$authGroups);
        $authrule = new AuthRuleModel();
        $authrules = $authrule->authRuleTree();
        $this->assign("authrules",$authrules);
        return view();
    }

    public function del(){
        $id = input("id");
        $request = db("auth_group")->delete($id);
        if($request){
            $this->success("删除用户组成功","lst");
        }else{
            $this->error("删除用户组失败");
        }

    }

}