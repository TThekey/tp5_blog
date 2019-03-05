<?php
namespace app\admin\validate;
use think\Validate;

class Cate  extends Validate
{
    protected $rule = [
        'catename'  =>  'require|max:25',

    ];

    protected $msg = [
        'catename.require' => '栏目名称必须填写',
        'catename.max' => '栏目名称不得多于25位',

    ];

    protected $scene = [
        "add" => ["catename"],
        "edit"=> ["catename"],

    ];
}