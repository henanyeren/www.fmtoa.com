<?php
namespace app\admin\validate;
use think\Validate;

class CashierManagement extends Validate{
    protected $rule=[
        'cashier_name'=>'require|max:255',
        'cashier_url'=>'require|max:255',
        'cashier_category'=>'require|max:2',
    ];
    protected $message=[
        'cashier_category.require'=>'类别必须选',
        'cashier_category.max'=>'类别格式错误',
        'cashier_name.require'=>'文档名不能空',
        'cashier_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'cashier_name'=>'cashier_name',
        'cashier_url'=>'cashier_url',
        'cashier_category'=>'cashier_category',
        'add'=>['cashier_name','cashier_url','cashier_category']
    ];
}