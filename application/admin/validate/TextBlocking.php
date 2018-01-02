<?php
namespace app\admin\validate;
use think\Validate;

class TextBlocking extends Validate{
    protected $rule=[
        'company_name'=>'require|max:255',
        'company_url'=>'require|max:255',
        'company_content'=>'require',

    ];
    protected $message=[
        'company_name.require'=>'文档名不能空',
        'company_url.require'=>'文档必须上传',
        'company_content.require'=>'详情不能为空',
    ];
    protected $scene=[
        'company_name'=>'company_name',
        'company_url'=>'company_url',
        'company_content'=>'company_content',
        'add'=>['company_name','company_url','company_content']
    ];
}