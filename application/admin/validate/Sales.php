<?php
namespace app\admin\validate;
use think\Validate;

class Sales extends Validate{
    protected $rule=[
        'sales_name'=>'require|max:255',
        'sales_url'=>'require|max:255',
        'sales_category'=>'require|max:2',
    ];
    protected $message=[
        'sales_category.require'=>'类别必须选',
        'sales_category.max'=>'类别格式错误',
        'sales_name.require'=>'文档名不能空',
        'sales_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'sales_name'=>'sales_name',
        'sales_url'=>'sales_url',
        'sales_category'=>'sales_category',
        'add'=>['sales_name','sales_url','sales_category']
    ];
}