<?php
namespace app\admin\validate;
use think\Validate;

class Article  extends Validate
{
    protected $rule = [
        'title'  =>  'require|max:25',
        'cateid' =>  'require',
    ];

    protected $msg = [
        'title.require' => '文章标题必须填写',
        'cateid.require' => '栏目必须选择',
    ];

    protected $scene = [
        "add" => ["title","cateid"],
        "edit"=> ["title","cateid"],

    ];
}