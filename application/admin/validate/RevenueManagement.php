<?php
namespace app\admin\validate;
use think\Validate;

class RevenueManagement extends Validate{
    protected $rule=[
        'revenue_name'=>'require|max:255',
        'revenue_url'=>'require|max:255',
        'revenue_category'=>'require|max:2',
    ];
    protected $message=[
        'revenue_category.require'=>'类别必须选',
        'revenue_category.max'=>'类别格式错误',
        'revenue_name.require'=>'文档名不能空',
        'revenue_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'revenue_name'=>'revenue_name',
        'revenue_url'=>'revenue_url',
        'revenue_category'=>'revenue_category',
        'add'=>['revenue_name','revenue_url','revenue_category']
    ];
}