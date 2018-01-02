<?php
	namespace app\phone\controller;
	use think\Controller;

	class Appver extends Controller{
	
		
		public function getver(){
			//获取最新app版本的信息
			$max_id=db('app_history')->max('app_id');
     		$app_new_info=db('app_history')->find($max_id);
			if($app_new_info){
				$app_new_info['status']='200';
			}
			return json_encode($app_new_info);
			//return json_encode(array('v'=>'1.0.4','src'=>'http://211.159.177.229/wwwroot/app/福妙堂.apk'));
		}	
	}