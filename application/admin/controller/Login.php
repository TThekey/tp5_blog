<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin;

class Login  extends Controller
{
    public function index()
    {
        if(request()->isPost()){
            $data = input("post.");
            $admin = new Admin();
            $result = $admin->login($data);

            if($result == 1){
                $this->error("该用户不存在");
            }elseif ($result == 2){
                $this->error("密码错误");
            }elseif ($result == 3){
                $this->success("登录成功","index/index");
            }elseif($result == 4){
                $this->error("验证码错误");
            }

        }
        return $this->fetch("login");
    }
}