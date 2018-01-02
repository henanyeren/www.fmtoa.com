<?php
namespace app\admin\validate;

class Ntfs extends \think\Validate
{
	protected $rule = [
        'cancer_name'  =>  'require|max:256',
       	'cancer_title'	=>	'require|max:512',
       	'cancer_content'	=>	'max:1024',
       	'cancer_content'	=>	'max:1024',
       	'cancer_content'	=>	'max:1024',
    ];
    
    protected $message = [
	    'cancer_name.require'	=> 	'文章名必填',
	    'cancer_title.require'	=> 	'请输入所属模块',
	    
	    
	    'cancer_name.max'		=>	'文章名不超过80个汉字',
	    'cancer_title.max'		=>	'标题超出长度',
	    
	    
	];
	
	protected $scene=[
		'add'=>['cancer_name','cancer_title'],
		'edit'=>['cancer_name','cancer_title'],
		'cancer_title'=>['cancer_title'],
		'cancer_name'=>['cancer_name'],
		'cancer_content'=>['cancer_content'],
		
	];
	
}
