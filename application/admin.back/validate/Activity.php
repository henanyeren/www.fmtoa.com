<?php
namespace app\admin\validate;
use think\Validate;

class Activity extends Validate{
    protected $rule=[
        'name'=>'require|max:25',
        'url'=>'require|max:255',
        'content'=>'require|max:200'
    ];
    protected $message=[
        'content.require'=>'描述不能为空',
        'name.require'=>'文档名不能空',
        'url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'content'=>'content',
        'name'=>'name',
        'url'=>'url',
        'add'=>['name','url','content']
    ];
}