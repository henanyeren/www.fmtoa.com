<?php
namespace app\admin\validate;

class PatientCircleTherapy extends \think\Validate
{
	protected $rule = [
        'patiend_name'  =>  'require|max:256',
       	'patiend_sex'	=>	'number|max:2',
       	'patiend_age'	=>	'max:130',
       	'patiend_nation'	=>	'max:256',
       	'patiend_marriage'	=>	'number|max:4',
       	
       	'patiend_profession'=>'require|max:256',
       	'patiend_work_addr'=>'require|max:512',
       	
       	'patiend_tel'=>'require|max:64',
       	'patiend_work_addr'=>'require|max:512',
       	
       	
       	'patiend_visi_time'=>'number',
       	'patiend_work_addr'=>'require|max:512',
       	
       	'patiend_work_addr'=>'require|max:512',
       	'patiend_work_addr'=>'require|max:512',
       	
    ];
    
    protected $message = [
	    'patiend_name.require'	=> 	'病人名字必填',
	    'patiend_sex.require'	=> 	'性别必填',
	    
	    'patiend_name.max'		=>	'姓名不超过80个汉字',
	    'patiend_sex.max'		=>	'性别超出最大值',
	    
	    'patiend_age'=>'年龄超出范围',
	    
	    'patiend_nation.max'		=>	'民族不超过80个汉字',
	    
	    'patiend_marriage.number'=>'婚姻必须是数字',
	    'patiend_marriage.max'=>'婚姻超出范围',

	    'patiend_work_addr.require'=>'地址必填',
	    'patiend_work_addr.max'=>'地址长度超出范围',
	    
	   	'patiend_tel.require'=>'电话地址必填',
	    'patiend_tel.max'=>'电话长度超出范围',
	    
	    'patiend_visi_time.number'=>'时间类型错误',
	
	    
	];
	
	protected $scene=[
		'add'=>['patiend_name','patiend_sex','patiend_sex','patiend_sex','patiend_sex','patiend_sex','patiend_sex'],
		'edit'=>['cancer_name','cancer_title'],
		'cancer_title'=>['cancer_title'],
		'cancer_name'=>['cancer_name'],
		'cancer_content'=>['cancer_content'],
		
	];
	
}
