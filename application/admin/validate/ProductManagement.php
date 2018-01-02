<?php
namespace app\admin\validate;
use think\Validate;

class ProductManagement extends Validate{
    protected $rule=[
        'product_name'=>'require|max:255',
        'product_url'=>'require|max:255',
        'product_category'=>'require|max:2',
    ];
    protected $message=[
        'product_category.require'=>'类别必须选',
        'product_category.max'=>'类别格式错误',
        'product_name.require'=>'文档名不能空',
        'product_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'product_name'=>'product_name',
        'product_url'=>'product_url',
        'product_category'=>'product_category',
        'add'=>['product_name','product_url','product_category']
    ];
}