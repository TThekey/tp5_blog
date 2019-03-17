<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Base;
use think\Auth;
use think\Request;

class Admin  extends Base
{
    public function lst()
    {
        $auth = new Auth();
        $list = AdminModel::paginate(3);
        foreach ($list as $k=>$v){
                $_grouptitle = $auth->getGroups($v['id']);
                if($_grouptitle){
                    $grouptitle = $_grouptitle[0]['title'];
                    $v['grouptitle'] = $grouptitle;
                }
        }
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){
//        $request = Request::instance();
//        $par = $request->param();
//        dump($par);die;

            $date=[
              "username"=>input("username"),
              "password"=>md5(input("password")),
            ];

           $validate = validate("Admin");

            if(!$validate->scene("add")->check($date)){
                $this->error($validate->getError());

            }

            //$request = db("admin")->insert($date);
            $admin = AdminModel::create($date);

            if($admin){
                $groupAccess=[
                    "uid"=>$admin['id'],
                    "group_id"=>input("group_id"),
                ];
                db("auth_group_access")->insert($groupAccess);
                return $this->success("添加管理员成功","lst");

            }else{
                return $this->error("添加管理员失败");
            }

            return;
        }

        $authGroupRes = db("auth_group")->select();
        $this->assign("authGroupRes",$authGroupRes);

        return $this->fetch();
    }

    public function edit(){

//        $request = Request::instance();
//        $par = $request->param();
//        dump($par);die;


        $id = input("id");
//        dump($id);die;
        $admins = db("admin")->find($id);

        if(request()->isPost()){
            $data =[
                "id" => input("id"),
                "username" => input("username"),
            ];
            if(input("password")){
                $data["password"] = md5(input("password"));
            }else{
                $data["password"] = $admins["password"];
            }

            $validate = validate("Admin");

            if(!$validate->scene("edit")->check($data)){
                $this->error($validate->getError());

            }

            $request = db("admin")->update($data);
            if($request !== false){
                $groupAccess=[
                    "uid"=>input("id"),
                    "group_id"=>input("group_id"),
                ];
                db("auth_group_access")->where("uid",$groupAccess['uid'])->setField("group_id",$groupAccess['group_id']);

                return $this->success("修改管理员成功","lst");

            }else{
                return $this->error("修改管理员失败");
            }

            return;
        }

        $authGroupAccess = db("auth_group_access")->where(array("uid"=>$id))->find();
        $authGroupRes = db("auth_group")->select();
        $this->assign("authGroupRes",$authGroupRes);
        $this->assign("admins",$admins);
        $this->assign("GroupID",$authGroupAccess['group_id']);
        return $this->fetch();
    }

    public function del(){
        $id = input("id");

        if($id != 1){
            $request = db("admin")->delete($id);
            if($request){
                $this->success("删除管理员成功","lst");
            }else{
                $this->error("删除管理员失败");
            }
        }else{
            $this->error("初始化管理员不能删除!");
        }
    }

    public function  logout(){

        session(null);
        $this->success("退出成功","login/index");

    }

    /*
     *
     *
     * */
//

/**
 *
 *
 *
 */

/**
 *
 */



}