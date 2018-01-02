<?php
namespace app\admin\validate;
use think\Validate;

class PersonnelManagement extends Validate{
    protected $rule=[
        'personnel_name'=>'require|max:255',
        'personnel_url'=>'require|max:255',
        'personnel_category'=>'require|max:2',
    ];
    protected $message=[
        'personnel_category.require'=>'类别必须选',
        'personnel_category.max'=>'类别格式错误',
        'personnel_name.require'=>'文档名不能空',
        'personnel_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'personnel_name'=>'personnel_name',
        'personnel_url'=>'personnel_url',
        'personnel_category'=>'personnel_category',
        'add'=>['personnel_name','personnel_url','personnel_category']
    ];
}