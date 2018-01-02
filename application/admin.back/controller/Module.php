<?php
	namespace app\admin\controller;
	use think\Controller;

	class Module extends Common{
		
		public function add()
		{
			//$pids=$this->getLevelChild();
			
			
			$model_list=db('module')->select();
			$pids=model('module')->getChildren($model_list);
			$this->assign('pids',$pids);		
			
			
			$re=[
				'status'=>1,
				'page'=>$this->fetch('add'),
			];
				
			return $re;
		}
		
		//添加处理数据
		public function addhanddle()
		{
			$data=[
				'module_name'=>input('module_name'),
				'module_pid'=>input('module_pid'),
				'module_status'=>input('module_status'),
				'module_icon'=>input('module_icon'),
				'module_url'=>input('module_url'),
			];
			
//			$validate=validate('Module');
//			if(!$validate->scene('add')->check($data)){
//				$this->error($validate->getError());
//			}
			$re=db('module')->insert($data);
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
		$pids=db('module')->where('pid',$pid)->select();
	}
	
		
	public function lst()
	{
			$module_list_select=db('module')->select();
			$model=model('module');
			$list=$model->getChildren($module_list_select);
			
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'模块列表',
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
		$detail_info=db('module')->find($id);
		$this->assign('detail_info',$detail_info);
		
		//递归获取
		$model_list=db('module')->select();
		$pids=model('module')->getChildren($model_list);
		$this->assign('pids',$pids);
		
			
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
				'module_id'=>input('module_id'),
				'module_name'=>input('module_name'),
				'module_pid'=>input('module_pid'),
				'module_status'=>input('module_status'),
				'module_icon'=>input('module_icon'),
				'module_url'=>input('module_url'),
			];
			$id=$data['module_id'];
		unset($data['module_id']);
		$validate=validate('Module');
		if(!$validate->scene('add')->check($data)){
			$this->error($validate->getError());
		}
		$re=db('module')->where('module_id',$id)->update($data);
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
				
				$validate=validate('Module');
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
			$id=input('module_id');
			if(db('module')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	}
