<?php
namespace app\admin\controller;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\controller\Base;

class AuthRule  extends Base
{
    //前置勾子
    protected $beforeActionList = [
        'delson'  =>  ['only'=>'del'],
    ];

    public function lst()
    {
        $authrule = new AuthRuleModel;

        //排序逻辑
        if(request()->isPost()){
            $sorts = input("post.");
            foreach ($sorts as $k=>$v){
                $authrule->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success("更新排序成功","lst");
            return;
        }

        $authrules = $authrule->authRuleTree();
        $this->assign("authrules",$authrules);
        return view();
    }

    public function add()
    {
        //添加逻辑
        if(request()->isPost()){
            $data = input("post.");
            $plevel =db("auth_rule")->where("id",$data['pid'])->field("level")->find(); //得到父级level
            if($plevel){
                $data['level'] = $plevel['level']+1;
            }else{
                $data['level'] = 0;
            }

            $add = db("auth_rule")->insert($data);
            if($add){
                $this->success("添加权限成功","lst");
            }else{
                $this->error("添加权限失败");
            }
            return;
        }

        //添加界面
        $authrule = new AuthRuleModel;
        $authrules = $authrule->authRuleTree();
        $this->assign("authrules",$authrules);
        return view();
    }

    public function edit()
    {
        $id = input("id");
        $authRules = db("auth_rule")->find($id);

        //编辑逻辑
        if(request()->isPost()){
            $data = input("post.");
            $plevel =db("auth_rule")->where("id",$data['pid'])->field("level")->find();
            if($plevel){
                $data['level'] = $plevel['level']+1;
            }else{
                $data['level'] = 0;
            }

            $add = db("auth_rule")->update($data);
            if($add){
                $this->success("修改权限成功","lst");
            }else{
                $this->error("修改权限失败");
            }
            return;
        }

        //编辑界面
        $authrule = new AuthRuleModel;
        $authrules = $authrule->authRuleTree();
        $this->assign([
           "authrules" => $authrules,
            "authRules" => $authRules
        ]);
        return view();
    }

    public function del()
    {
        $id = input("id");
        $request = db("auth_rule")->delete($id);
        if($request){
            $this->success("删除权限成功","lst");
        }else{
            $this->error("删除权限失败");
        }
    }

    public function delson(){
        $id = input("id");
        $authrule = new AuthRuleModel;
        $ids = $authrule->getchildrenid($id);   //得到所有子id
        if($ids){
            AuthRuleModel::destroy($ids);
        }
    }

}