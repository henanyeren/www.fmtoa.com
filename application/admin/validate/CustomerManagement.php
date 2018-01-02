<?php
namespace app\admin\validate;
use think\Validate;

class CustomerManagement extends Validate{
    protected $rule=[
        'customer_name'=>'require|max:255',
        'customer_url'=>'require|max:255',
        'customer_category'=>'require|max:2',
    ];
    protected $message=[
        'customer_category.require'=>'类别必须选',
        'customer_category.max'=>'类别格式错误',
        'customer_name.require'=>'文档名不能空',
        'customer_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'customer_name'=>'customer_name',
        'customer_url'=>'customer_url',
        'customer_category'=>'customer_category',
        'add'=>['customer_name','customer_url','customer_category']
    ];
}