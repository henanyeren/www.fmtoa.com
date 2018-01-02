<?php
	namespace app\admin\controller;
	use think\Controller;

	class WebFeedback extends Common{
		
	public function lst()
	{
			$list=db('AppWebFeedback')->order('feedback_id desc')->paginate(10);
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'建议',
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
			if(db('AppWebFeedback')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
        
	public function detail()
	{
		$id=input('id');
		
		$detail=db('AppWebFeedback')->find($id);
		if($detail){
			$this->assign('detail',$detail);
			return array('state'=>'1','msg'=>$this->fetch(),'name'=>'意见反馈');
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
	}
