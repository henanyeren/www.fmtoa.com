<?php
namespace app\admin\validate;
use think\Validate;

class CommonProblem extends Validate{
    protected $rule=[
        'problem_name'=>'require|max:255',
        'problem_content'=>'require',
    ];
    protected $message=[
        'problem_name.require'=>'问题不能为空',
        'problem_content.require'=>'答案不能为空',
        'problem_name.max'=>'问题不能超过80字',
    ];
    protected $scene=[
        'problem_name'=>'problem_name',
        'problem_content'=>'problem_content',
        'add'=>['problem_name','problem_content']
    ];
}