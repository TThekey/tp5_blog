<?php
namespace app\admin\controller;
use think\Auth;
use think\Controller;
use think\Request;

class Base  extends Controller
{
    public function _initialize()
    {
        if(!session("username")){
            $this->error("请先登录","login/index");
        }

        $auth = new Auth();
        $request = Request::instance();
        $controller = $request->controller();   //得到当前控制器
        $action = $request->action();   //得到当前方法
        $name = $controller.'/'.$action;
        $notCheck = array("Index/index","Admin/lst","Admin/logout");    //白名单
        if(session("uid")!=1){
            if(!in_array($name,$notCheck)){
                if(!$auth->check($name,session("uid"))){
                    $this->error("没有权限","index/index");
                }
            }
        }
    }
}