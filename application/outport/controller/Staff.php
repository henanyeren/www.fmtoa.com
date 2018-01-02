<?php
	namespace app\outport\controller;
	use think\Controller;

	class Staff extends Controller{

		
	public function lst()
	{
			$list=db('staffLog')->paginate();
			
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'员工日志列表',
			]);	
			
			$re=[
				'status'=>1,
				'page'=>$this->fetch('lst'),
			];
			
			if(request()->isAjax()){
				return $re;
			}
			
	}
	
	public function search()
	{
		return view();
			
	}	
	
	public function getStaffInfo(){
		
		$res=input('res');
		
		$list=db('staff')
	    ->where('staff_name|staff_id','like',"%$res%")
	    ->paginate(3);
	    
	    if(sizeof($list)){
			$this->assign('list',$list);
			
			$re=[
				'page'=>$this->fetch(),
				'status'=>1,
			];
			
			return $re;	    	
	    }else{
	    	$re=[
	    		'msg'=>'未找到。。。',
	    		'status'=>0,
	    	];
	    	return $re;
	    }
	    
	}
	

		
	public function detail()
	{
		$id=input('userid');
		$detail=db('staff')->find($id);
		$this->assign('detail',$detail);
		if($detail){
			return array('status'=>'1','page'=>$this->fetch());
		}else{
			return array('status'=>'0','msg'=>'查询错误');
		}
			
	}
		
	}
