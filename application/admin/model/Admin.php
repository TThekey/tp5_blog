<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Admin extends Model
{
    public function login($data){
        $captcha = new \think\captcha\Captcha();    //调用验证码类
        if(!$captcha->check($data["code"])){
            return 4;
        }

        $user = Db::name("admin")->where("username","=",$data["username"])->find();
        if($user){
            if($user["password"] == md5($data["password"])){
                session("username",$user["username"]);  //存入session
                session("uid",$user["id"]);
                return 3;  //密码正确
            }else{
                return 2;  //密码不正确
            }
        }
        else{
            return 1;  //用户名不存在
        }
    }
}