<?php
namespace app\admin\validate;
use think\Validate;

class CooperativeOrganization extends Validate{
    protected $rule=[
        'co_img'=>'require|max:255',
        'co_name'=>'require|max:255',
        'co_content'=>'require',
    ];
    protected $message=[
        'co_img.require'=>'图片不能为空不能为空',
        'co_content.require'=>'详情不能为空',
        'co_name.require'=>'名称不能为空',
        'co_name.max'=>'名称不能超过80字',
    ];
    protected $scene=[
        'co_name'=>'co_name',
        'add'=>['co_img','co_name','co_content']
    ];
}