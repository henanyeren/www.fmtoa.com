<?php
namespace app\admin\validate;
use think\Validate;

class Papers extends Validate{
    protected $rule=[
        'papers_name'=>'require|max:255',
        'papers_path'=>'require|max:255',
        'papers_content'=>'require',

    ];
    protected $message=[
        'papers_name.require'=>'文档名不能空',
        'papers_path.require'=>'文档必须上传',
        'papers_content.require'=>'详情不能为空',
    ];
    protected $scene=[
        'papers_name'=>'papers_name',
        'papers_path'=>'papers_path',
        'papers_content'=>'papers_content',
        'add'=>['papers_name','papers_path','papers_content']
    ];
}