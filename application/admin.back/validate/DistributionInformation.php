<?php
namespace app\admin\validate;
use think\Validate;

class DistributionInformation extends Validate{
    protected $rule=[
        'distribution_img'=>'require|max:255',
        'distribution_name'=>'require|max:255',
        'distribution_content'=>'require',
    ];
    protected $message=[
        'distribution_img.require'=>'图片不能为空',
        'distribution_name.require'=>'标题不能为空',
        'distribution_content.require'=>'信息不能为空',
        'distribution_name.max'=>'标题不能多于80字',
    ];
    protected $scene=[
        'distribution_img'=>'distribution_img',
        'distribution_name'=>'distribution_name',
        'distribution_content'=>'distribution_content',
        'add'=>['distribution_img','distribution_name','distribution_content']
    ];
}