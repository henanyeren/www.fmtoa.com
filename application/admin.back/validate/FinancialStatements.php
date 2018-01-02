<?php
namespace app\admin\validate;
use think\Validate;

class FinancialStatements extends Validate{
    protected $rule=[
        'financial_name'=>'require|max:255',
        'financial_url'=>'require|max:255',
        'financial_category'=>'require|max:2',
    ];
    protected $message=[
        'financial_category.require'=>'类别必须选',
        'financial_category.max'=>'类别格式错误',
        'financial_name.require'=>'文档名不能空',
        'financial_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'financial_name'=>'financial_name',
        'financial_url'=>'financial_url',
        'financial_category'=>'financial_category',
        'add'=>['financial_name','financial_url','financial_category']
    ];
}