<?php
namespace app\admin\validate;

class AppNotice extends \think\Validate
{
	protected $rule = [
        'app_name'  =>  'require|max:256',
       	'app_title'	=>	'require|max:512',
    ];
    
    protected $message = [
	    'app_name.require'	=> 	'文章名必填',
	    'app_title.require'	=> 	'请输入标题',
	    
	    
	    'app_name.max'		=>	'文章名不超过80个汉字',
	    'app_title.max'		=>	'标题超出长度',
	    
	    
	];
	
	protected $scene=[
		'add'=>['app_name','app_title'],
		'edit'=>['app_name','app_title'],
		
		'app_title'=>['app_title'],
		'app_name'=>['app_name'],
		
	];
	
}
