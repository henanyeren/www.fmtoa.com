<?php
	namespace app\admin\controller;
	use think\Controller;

	class Feedback extends Common{
		
	public function lst()
	{
			$list=db('AppFeedback')->order('feedback_id desc')->paginate(10);
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'反馈意见',
			]);	
			$re=[
				'status'=>1,
				'page'=>$this->fetch('lst'),
			];
			if(request()->isAjax()){
				return $re;
			}
	}
	
	
        
		
		
		public function del()
		{
			$id=input('feedback_id');
			if(db('AppFeedback')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
        
	public function detail()
	{
		$id=input('id');
		
		$detail=db('AppFeedback')->find($id);
		if($detail){
			$this->assign('detail',$detail);
			return array('state'=>'1','msg'=>$this->fetch(),'name'=>'意见反馈');
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
	}
