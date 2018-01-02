<?php
	namespace app\phone\controller;
	use think\Controller;

	class StaffLog extends Controller{
		//添加处理数据
		public function addhanddle()
		{
			$data=[
				'staff_content'=>input('logcon'),
				'staff_username'=>input('username'),
				'staff_admin_id'=>input('user_id'),
				'staff_log_time'=>time()
			];
			if(db('staffLog')->insert($data)){
				return "提交成功";
			}else{
				return "提交失败";
			}
			return ;
		}
		
		public function lst(){
		
		}		
		
		
	}
