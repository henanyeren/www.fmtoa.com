<?php
	namespace app\admin\controller;
	use think\Controller;

		
	class Duty extends Common{
		public function add()
		{

			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}
		//添加处理数据
		public function addhanddle()
		{
			$post=request()->post();
			$data=[
				'duty_name'=>$post['duty_name'],
			];
			$re_id=db('duty')->insertGetId($data);
			$duty_super_id=$post['duty_super_id'].'-'.$re_id;
			
			$re=db('duty')->where('duty_id',$re_id)->update(['duty_super_id'=>$duty_super_id]);
			if($re){
				return array('state'=>1,'msg'=>'规则添加成功');
			}else{
				return array('state'=>0,'msg'=>'规则添加失败');
			}
			return ;
		}
	
		public function getLevelChild($pid=0)
		{
			$new_pid=input('pid');
			$pid=$new_pid?$new_pid:0;
			$pids=db('duty')->where('pid',$pid)->select();
		}	
		
	public function lst()
	{
			$list=db('duty')->select();
			$new_list=model('duty')->getChildren($list);
			$this->assign([
				'list'=>$new_list,
				'tabTitle'=>'部门列表',
			]);	
			
			$re=[
				'status'=>1,
				'page'=>$this->fetch('lst'),
			];
			
			if(request()->isAjax()){
				return $re;
			}
	}
	
	//修改获取页面
	public function upd()
	{
		$id=input('id');
		$detail_info=db('duty')->find($id);
		$this->assign('detail_info',$detail_info);
		
		$list=db('duty')->select();
		
		$pids=model('duty')->getChildren($list);
		$this->assign([
			'pids'=>$pids,
		]);			
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch('upd'),
		];
		
		return $re;
	}
	
	//修改上传数据
	public function updhanddle()
	{
		$data=[
				'duty_id'=>input('duty_id'),
				'duty_name'=>input('duty_name'),
				'duty_super_id'=>input('duty_super_id').'-'.input('duty_id'),
			];
		$id=$data['duty_id'];
		unset($data['duty_id']);
		
		$re=db('duty')->where('duty_id',$id)->update($data);
		if($re){
			return array('state'=>1,'msg'=>'修改成功');
		}else{
			return array('state'=>0,'msg'=>'修改失败');
		}
		
	}
		public function checkAjax()
		{
			if(request()->isAjax()){
				$admin_post=request()->post();
				$key=array_keys($admin_post)[0];
				
				$validate=validate('duty');
				if(!$validate->scene($key)->check($admin_post))
				{
					return array('state'=>'0','msg'=>$validate->getError());
				}else{
					return array('state'=>'1','msg'=>'名称可以使用');
				}
			}
		}
		public function del()
		{
			$id=input('duty_id');
			if(db('duty')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('id');
		$detail=db('duty')->find($id);
		if($detail){
			return array('state'=>'1','msg'=>$detail['duty_duty'],'name'=>$detail['duty_name']);
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
		
	//获取职位信息插件
	public function getDutyInfoPlug(){
		
		$pid=input('pid')?input('pid'):1;
	    $pids=db('duty')->where('duty_pid',$pid)->select();
	    
	    if(!$pids){
			$re=[
				'state'=>2,
				'page'=>'😙 没有下级了！',
			]; 
			return $re;	    	
	    }
	    $this->assign('list',$pids);
	    
		$re=[
			'state'=>1,
			'page'=>$this->fetch('dutyinfo'),
		]; 
		return $re;
		
	}	
	
		
	}
