<?php
	namespace app\phone\controller;
	use think\Controller;

	class AppCallback extends Controller{
		
		public function addhanddle()
		{
			$data=[
				'feedback_information'=>input('callback_info'),
				'feedback_user_name'=>input('user_name'),
				'feedback_user_id'=>input('user_id'),
				'feedback_time'=>time()
			];
			if(db('app_feedback')->insert($data)){
				return json_encode(array('status'=>'200','msg'=>"提交成功"));
			}else{
				return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}
			return ;
		}
		        
        
		
	}
