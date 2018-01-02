<?php
	namespace app\admin\controller;
	use think\Controller;

	class Department extends Common{
		
		public function add()
		{
			
			$list=db('Department')->select();
			
			$pids=model('Department')->getChildren($list);
			$this->assign([
				'pids'=>$pids,
				'tabTitle'=>'添加疑难杂症',
			]);	
			$re=[
				'status'=>1,
				'page'=>$this->fetch('add'),
			]; 
			return $re;
		}
		
		//添加处理数据
		public function addhanddle()
		{
			$data=request()->post();
			
			
			$re=db('Department')->insert($data);
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
			$pids=db('Department')->where('pid',$pid)->select();
		}
	
		
	public function lst()
	{
			$list=db('Department')->select();
			
			$pids=model('Department')->getChildren($list);			
			
			$this->assign([
				'list'=>$pids,
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
		$detail_info=db('Department')->find($id);
		$this->assign('detail_info',$detail_info);
		
		$list=db('Department')->select();
		
		$pids=model('Department')->getChildren($list);
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
				'department_id'=>input('department_id'),
				'department_name'=>input('department_name'),
				'department_duty'=>input('department_duty'),
			];
			dump($data);
		$id=$data['department_id'];
		unset($data['department_id']);
		
		$re=db('Department')->where('department_id',$id)->update($data);
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
				
				
				$validate=validate('Department');
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
			$id=input('department_id');
			if(db('Department')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('id');
		$detail=db('Department')->find($id);
		if($detail){
			return array('state'=>'1','msg'=>$detail['department_duty'],'name'=>$detail['department_name']);
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
		
	}
