<?php
namespace app\admin\validate;

class Module extends \think\Validate
{
	protected $rule = [
        'module_name'  =>  'require|max:60',
       	'module_pid'	=>	'require|max:60',
       	'module_status'	=>	'require|max:60',
       	'module_icon'	=>	'require|max:60',
       	'module_url'	=>	'max:60',
    ];
    
    protected $message = [
	    'module_name.require'	=> 	'请输入模块名',
	    'module_pid.require'	=> 	'请输入所属模块',
	    'module_status.require'	=> 	'请输入状态',
	    'module_icon.require'	=> 	'请输入图标',
	    
	    
	    'module_name.max'		=>	'模块名不超过20个汉字',
	    'module_pid.max'		=>	'所属模块长度不超过20个汉字',
	    'module_status.max'		=>	'模块状态长度不超过20个汉字',
	    'module_icon.max'		=>	'图标长度不超过60个字符',
	    'module_url.max'		=>	'模块url长度不超过60个字符',
	    
	    
	];
	
	protected $scene=[
		'add'=>['module_name','title','module_pid','module_status','module_url'],
		'edit'=>['module_name','title','module_pid','module_status','module_url'],
		'module_name'=>['module_name'],
		'module_pid'=>['module_pid'],
		'module_status'=>['module_status'],
		'module_icon'=>['module_icon'],
		'module_url'=>['module_url'],
	];
	
}
