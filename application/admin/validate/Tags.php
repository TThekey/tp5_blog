<?php
namespace app\admin\validate;
use think\Validate;

class Tags  extends Validate
{
    protected $rule = [
        'tagname' =>  'require|unique:tag',
    ];

    protected $msg = [
        'tagname.require' => '标签名称必须填写',
        'tagname.unique'  => 'Tags标签不能重复',
    ];

    protected $scene = [
        "add" => ["tagname"],
        "edit"=> ["tagname"],

    ];
}