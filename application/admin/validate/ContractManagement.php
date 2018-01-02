<?php
namespace app\admin\validate;
use think\Validate;

class ContractManagement extends Validate{
    protected $rule=[
        'contract_name'=>'require|max:255',
        'contract_url'=>'require|max:255',
        'contract_category'=>'require|max:2',
    ];
    protected $message=[
        'contract_category.require'=>'类别必须选',
        'contract_category.max'=>'类别格式错误',
        'contract_name.require'=>'文档名不能空',
        'contract_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'contract_name'=>'contract_name',
        'contract_url'=>'contract_url',
        'contract_category'=>'contract_category',
        'add'=>['contract_name','contract_url','contract_category']
    ];
}