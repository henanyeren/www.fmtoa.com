<?php
	namespace app\phone\controller;
	use think\Controller;

	class AppNotice extends Controller{
		
	public function detail()
	{
		$id=input('cancer_id');
		$detail=db('staffLog')->find($id);
		if($detail){
			return array('state'=>'1','msg'=>$detail['staff_content']);
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
			
	}
	
		
	public function lst()
	{
			$list=db('AppNotice')->paginate(2)->each(function($item,$key){
				dump(json_encode($item));
			});
		
			dump($list);
				
			if($list){
				$re=[
					'status'=>1,
				];
			}
	}
		
		
		
	}
