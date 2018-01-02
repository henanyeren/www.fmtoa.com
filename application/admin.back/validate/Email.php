<?php
namespace app\admin\validate;
class Email extends \think\Validate
{
	protected $rule = [
        'email_from_id'  =>  'require|number',
       	'email_to_id'	=>	'require|number',
       	'email_title'	=>	'require|length:2,100',
    ];
    
    protected $message = [
	    'email_from_id.require'	=> 	'您未登录，不能发送',
	    'email_from_id.number'	=> 	'您的身份异常',
	    
	    
	    'email_to_id.require'		=>	'未知收件人',
	    'email_to_id.number'		=>	'收件人异常',
	    
	    'email_title.require'		=>'邮件标题必填',
	    'email_title.length'		=>'邮件标题字符应在1-30字符之间',
	    
	    
	    
	];
	
	protected $scene=[
		'add'=>['email_from_id','email_to_id','email_title'],
		
	];
	
}
