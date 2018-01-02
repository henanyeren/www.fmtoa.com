<?php
namespace app\admin\validate;
use think\Validate;

class Upload extends Validate{
    protected $rule=[
        'app_file'=>'require',
        'app_number'=>'require|min:5|max:10',
        'app_log'=>'require',
        'app_remark'=>'require|max:255',
    ];
    protected $message=[
        'app_file.require'=>'文件必须上传',
        'app_number.require'=>'版本号不能为空',
        'app_number.min'=>'版本号格式不正确',
        'app_number.max'=>'版本号格式不正确',
        'app_log.require'=>'日志不能为空',
        'app_remark.require'=>'备注必须填写',
       'app_remark.max'=>'备注超过字数限制',
    ];
    protected $scene=[
        'app_file'=>'app_file',
        'app_number'=>'app_number',
        'app_log'=>'app_log',
        'app_remark'=>'app_remark',
    ];
}