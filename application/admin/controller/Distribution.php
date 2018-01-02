<?php
	namespace app\admin\controller;
	use think\Controller;

	class Distribution extends Common{
		
		//添加
		public function addarea()
		{
			$list=db('distribution_area')->select();
			$pids=model('Distribution')->getChildren($list);
			//dump($pids);
			$this->assign([
				'pids'=>$pids,
			]);	
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
				'distribution_name'=>$post['distribution_name'],
			];
			$re_id=db('distribution_area')->insertGetId($data);
			$distribution_area_super_id=$post['distribution_super_id'].'-'.$re_id;
			
			$re=db('distribution_area')->where('distribution_id',$re_id)->update(['distribution_super_id'=>$distribution_area_super_id]);
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
			$pids=db('distribution_area')->where('pid',$pid)->select();
		}	
		
		//铺货地区列表
	public function lstarea()
	{
			$list=db('distribution_area')->select();
			$new_list=model('Distribution')->getChildren($list);
			$this->assign([
				'list'=>$new_list,
				'tabTitle'=>'部门列表',
			]);	
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			
			if(request()->isAjax()){
				return $re;
			}
	}
	
	//修改获取页面
	public function upd()
	{
		$id=input('id');
		$detail_info=db('distribution_area')->find($id);
		$this->assign('detail_info',$detail_info);
		
		$list=db('distribution_area')->select();
		
		$pids=model('distribution_area')->getChildren($list);
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
				'distribution_area_id'=>input('distribution_area_id'),
				'distribution_area_name'=>input('distribution_area_name'),
				'distribution_area_super_id'=>input('distribution_area_super_id').'-'.input('distribution_area_id'),
			];
		$id=$data['distribution_area_id'];
		unset($data['distribution_area_id']);
		
		$re=db('distribution_area')->where('distribution_area_id',$id)->update($data);
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
				
				
				$validate=validate('distribution_area');
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
			$id=input('distribution_area_id');
			if(db('distribution_area')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('id');
		$detail=db('distribution_area')->find($id);
		if($detail){
			return array('state'=>'1','msg'=>$detail['distribution_area_distribution_area'],'name'=>$detail['distribution_area_name']);
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
		
	}
