<?php
namespace app\admin\validate;

class StaffType extends \think\Validate
{
	protected $rule = [
        'name'  =>  'require|max:60|unique:staff_type',
       	'pid'	=>	'number'
    ];
    protected $message = [
	    'name.require'	=> 	'请输入规则',
	    'name.unique'	=>	'该规则已经存在',
	    'name.max'		=>	'规则长度不超过20个汉字',
	    'pid.number'	=>	'父id必须为数字',
	    
	];
	
	protected $scene=[
		'add'=>['name','title'],
		'name'=>['name'],
		'pid'=>['pid'],
	];
	
}
