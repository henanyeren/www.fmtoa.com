<?php
namespace app\admin\validate;

class Staff extends \think\Validate
{
	protected $rule = [
	    'staff_graduate_institutions'=>'require|max:100',
        'staff_major'=>'require|max:100',

        'staff_professional_title'=>'require|max:255',
        'st_job_content'=>'require|max:1024',
        'staff_job_desc'=>'require|max:1024',

		'staff_department'=>'require',
        'staff_name'  =>  'require|max:15',
       	'staff_age'	=>	'require|elt:150',
       	'staff_bloodiness'	=>	'require|max:64',
       	'staff_native_place'	=>	'require|max:255',
		'staff_nation'=>'require|max:64',
		
       	'staff_standard_of_culture'	=>	'require|max:255',
       	'staff_healthy_condition'	=>	'require|max:255',
       	'staff_height'		=>	'require|number|elt:250',
	    'staff_weight'		=>	'require|elt:150',
	    
	    
       	'staff_marital_status'	=>	'require|max:3',
       	'staff_id_number'	=>	'require|max:18|checkIDs',
       	'staff_tel'	=>	'require|max:11|checkTel',
       	
       	'staff_census_register'	=>	'require|max:255',
       	'staff_skill'	=>	'require|max:255',
       	'staff_address'	=>	'require|max:255',
       	'staff_emergency_contact'	=>	'require|max:11|checkTel',
       	'staff_postalcode'	=>	'require|max:6',


        'staff_duty_super_id'=>'require',
    ];
    
    protected $message = [
        'staff_duty_super_id.require'=>'职位必须选',

        'staff_professional_title.require'=>'职称必须填',
        'staff_job_content.require'=>'工作内容必须填',
        'staff_job_desc.require'=>'职位描述必须填',

        'staff_professional_title.max'=>'职称超出长度',
        'st_job_content.max'=>'工作内容超出长度',
        'staff_job_desc.max'=>'职位描述超出长度',

        'staff_graduate_institutions.require'=>'毕业院校必须填',
        'staff_graduate_institutions.max'=>'毕业院校过长',

        'staff_major.require'=>'所学专业必须填',
        'staff_major.max'=>'所学专业超出长度',
        'staff_department.require'=>'部门名称必填',

    
	    'staff_name.require'	=> 	'员工名必填',
	    'staff_name.max'	=> 	'员工名字超出长度',
	    
	    'staff_sex.require'		=>	'员工性别必填',
	    'staff_sex.max'		=>	'标题超出长度',

	    'staff_age.require'		=>	'年龄必填',
	    'staff_age.elt'		=>	'年龄长度超出范围',
	    
	    'staff_bloodiness.max'		=>	'血型文章长度超出最大',
	    
	    'staff_native_place.require'		=>	'籍贯必填',
	    'staff_native_place.max'		=>	'籍贯超出长度',
	    
	    'staff_nation.require'		=>	'民族必填',	
	    'staff_nation.max'		=>	'民族长度超出范围',	
	  
	    'staff_standard_of_culture.require'		=>	'文化程度字必填',
	    'staff_standard_of_culture.max'		=>	'文化程度字符超出范围',
	    
	    'staff_healthy_condition.require'		=>	'健康必填',
	    'staff_healthy_condition.max'		=>	'健康超出长度超出范围',
	    
	    'staff_height.require'		=>	'身高必填',
	    'staff_height.max'		=>	'身高超出范围',
	    
	    'staff_weight.require'		=>	'体重必填',
	    'staff_weight.max'		=>	'体重超出范围',
	    
	    'staff_marital_status.require'		=>	'婚姻情况',
	    'staff_marital_status.max'		=>	'婚姻情况错误',
	    
	    'staff_id_number.require'		=>	'身份证号必填',
	    'staff_id_number.max'		=>	'身份证号超出长度',
	    'staff_id_number.checkIDs'		=>	'身份证格式错误',
	    
	    'staff_tel.require'		=>	'联系电话必填',
	    'staff_tel.max'		=>	'联系电话超出长度',
	    'staff_tel.checkTel'		=>	'手机号码格式错误',
	    
	    'staff_census_register.max'		=>	'户籍所在地超出长度',	    	    	    	    	    	    	    	    	    	    	    	    
	    
	    'staff_skill.require'		=>	'员工技能必填',
	    'staff_skill.max'		=>	'技能长度超出范围',	 
	    
	    'staff_address.require'		=>	'员工现居住地址必填',
	    'staff_address.max'		=>	'员工现居住超出长度',
	    
	    'staff_emergency_contact.require'		=>	'紧急联系人必填',
	    'staff_emergency_contact.max'		=>	'紧急联系人超出长度',	 
	    
	    'staff_postalcode.require'		=>	'邮政编码必填',	
	    'staff_postalcode.max'		=>	'邮政编码超出长度',
	    

	];
	
	protected $scene=[
		'add'=>['staff_major','staff_graduate_institutions','staff_name','staff_age','staff_bloodiness','staff_native_place',
            'staff_standard_of_culture','staff_healthy_condition', 'staff_marital_status','staff_id_number','staff_tel',
            'staff_census_register','staff_skill','staff_address','staff_emergency_contact','staff_postalcode',
            'staff_job_content','staff_height','staff_duty_super_id','staff_weight','staff_professional_title','staff_job_desc'],


        'staff_professional_title'=>'staff_professional_title',
        'staff_job_content'=>'staff_job_content',
        'staff_job_desc'=>'staff_job_desc',


        'staff_major'=>['staff_major'],
        'staff_graduate_institutions'=>['staff_graduate_institutions'],
		'staff_name'=>['staff_name'],
		'staff_age'=>['staff_age'],
		//'staff_sex'=>['staff_sex'],
		'staff_bloodiness'=>['staff_bloodiness'],
		'staff_native_place'=>['staff_native_place'],
		
		'staff_nation'=>['staff_nation'],
		
		'staff_standard_of_culture'=>['staff_standard_of_culture'],
		'staff_healthy_condition'=>['cancer_content'],
		'staff_height'=>['staff_height'],
		'staff_weight'=>['staff_weight'],
		
		'staff_marital_status'=>['staff_marital_status'],
		'staff_id_number'=>['staff_id_number'],
		'staff_tel'=>['staff_tel'],
		
		'staff_census_register'=>['staff_census_register'],
		'staff_skill'=>['staff_skill'],
		'staff_address'=>['staff_address'],
		'staff_emergency_contact'=>['staff_emergency_contact'],
		//'cancer_name'=>['cancer_name'],
		'staff_postalcode'=>['staff_postalcode'],
	];
	
   public function checkTel($val)
   {
   		if(preg_match("/^1[34578]{1}\d{9}$/",$val)){  
		   return true;  
		}else{  
		   return false;  
		}
   }
   
	protected function checkIDs($val){
		return validation_filter_id_card($val);
	}
   
}




