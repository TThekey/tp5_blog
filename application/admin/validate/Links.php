<?php
namespace app\admin\validate;
use think\Validate;

class Links  extends Validate
{
    protected $rule = [
        'title'  =>  'require|max:25',
        'url' =>  'require',
    ];

    protected $msg = [
        'title.require' => '链接标题必须填写',
        'url.require' => '链接地址必须填写',
        'title.max' => '链接标题不得多于25位',

    ];

    protected $scene = [
        "add" => ["title","url"],
        "edit"=> ["title","url"],

    ];
}