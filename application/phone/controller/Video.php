<?php
	namespace app\phone\controller;
	use think\Controller;

	class Video extends Controller{
		public function lst(){
			$listInfo=db('video')->paginate(10);
			$list=$listInfo->toArray();
						
			if($list){
				$list['status']='200';	
			}
			return  json_encode($list);
			
		}	
	}
 