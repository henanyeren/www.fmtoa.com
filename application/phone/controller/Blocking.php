<?php
	namespace app\phone\controller;
	use think\Controller;

	class Blocking extends Controller{
		public function lst(){
			$listInfo=db('text_blocking')->field('company_id,company_name')->paginate(10);
			$list=$listInfo->toArray();
						
			if($list){
				$list['status']='200';	
			}
			return  json_encode($list);
			
		}	
		
		public function detail(){
			$id=input('app_id');
			$detail=db('text_blocking')->find($id);
			if($detail){
				return json_encode($detail);
			}else{
				return json_encode(array('找不到你要日志'));
			}
		}			
		
		
	}
 