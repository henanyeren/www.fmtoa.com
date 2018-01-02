<?php
namespace app\admin\validate;
use think\Validate;

class AttendanceManagement extends Validate{
    protected $rule=[
        'attendance_name'=>'require|max:255',
        'attendance_url'=>'require|max:255',
        'attendance_category'=>'require|max:2',
    ];
    protected $message=[
        'attendance_category.require'=>'类别必须选',
        'attendance_category.max'=>'类别格式错误',
        'attendance_name.require'=>'文档名不能空',
        'attendance_url.require'=>'文档必须上传',
    ];
    protected $scene=[
        'attendance_name'=>'attendance_name',
        'attendance_url'=>'attendance_url',
        'attendance_category'=>'attendance_category',
        'add'=>['attendance_name','attendance_url','attendance_category']
    ];
}