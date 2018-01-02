<?php
	namespace app\admin\controller;
	use think\Controller;

	class staffLog extends Common{
		
		public function add()
		{
			$this->assign([
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
			
			$validate=validate('staffLog');
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}
			$re=db('staffLog')->insert($data);
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
			$pids=db('staffLog')->where('pid',$pid)->select();
		}
	
		
	public function lst()
	{
			$list=db('staffLog')->paginate(30);
			
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
	
	
	
	//修改获取页面
	public function upd()
	{
		$id=input('id');
		$detail_info=db('staffLog')->find($id);
		$this->assign('detail_info',$detail_info);
		
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
				'cancer_id'=>input('cancer_id'),
				'cancer_name'=>input('cancer_name'),
				'cancer_title'=>input('cancer_title'),
				'cancer_content'=>input('cancer_content'),
			];
		$id=$data['cancer_id'];
		unset($data['cancer_id']);
		$validate=validate('staffLog');
		if(!$validate->scene('add')->check($data)){
			$this->error($validate->getError());
		}
		$re=db('staffLog')->where('cancer_id',$id)->update($data);
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
				
				
				$validate=validate('staffLog');
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
			$id=input('cancer_id');
			if(db('staffLog')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
	public function detail()
	{
		$id=input('id');
		$detail=db('staffLog')->find($id);	
		$detail['staff_log_time']=date('Y-m-d H:i:s',$detail['staff_log_time']);
		$this->assign('detail',$detail); 
		if($detail){
			return array('state'=>'1','msg'=>$this->fetch('detail'));
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
	}
