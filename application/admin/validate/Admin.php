<?php
namespace app\admin\validate;
use think\Validate;

class Admin  extends Validate
{
    protected $rule = [
        'username'  =>  'require|max:25|unique:admin',
        'password' =>  'require',
    ];

    protected $msg = [
        'username.require' => '管理员名称必须填写',
        'username.unique'=>'管理员名称不能重复',
        'password.require' => '管理员密码必须填写',
        'username.max' => '管理员名称不得多于25位',

    ];

    protected $scene = [
        "add" => ["username","password"],
        "edit"=> ["username"=>"require|max:25|unique:admin" ],

    ];
}