<?php
	namespace app\admin\controller;
	use think\Controller;

	class StaffType extends Controller{
		
		public function add()
		{
			$post=request()->post();
			if($post){
				
				$data=[
					'name'=>input('name'),
					'pid'=>input('pid'),
				];
				
				$validate=validate('StaffType');
				if(!$validate->scene('add')->check($data)){
					$this->error($validate->getError());
				}
				$re=db('staff_type')->insert($data);
				if($re){
					return array('state'=>1,'msg'=>'类型添加成功');
				}else{
					return array('state'=>0,'msg'=>'类型添加失败');
				}
					
				return ;
			}
			
			
			$re=[
				'status'=>1,
				'page'=>$this->fetch('add'),
			];
			return $re;
		}
		
	public function lst()
	{

			$list=db('staff_type')->paginate(5);
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'人员类型列表',
			]);	
			
			$re=[
				'status'=>1,
				'page'=>$this->fetch('lst'),
			];
			
			if(request()->isAjax()){
				return $re;
			}
			
	}
	
	//修改方法
	public function edit()
	{
		$post=request()->post();
		if($post){
			$data=[
				'name'=>input('name'),
				'title'=>input('title'),
			];
			
			$validate=validate('Rights');
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}
			$re=db('staff_type')->insert($data);
			if($re){
				return array('state'=>1,'msg'=>'规则添加成功');
			}else{
				return array('state'=>0,'msg'=>'规则添加失败');
			}
				
			return ;
		}
		
		$id=input('id');
		$detail_info=db('staff_type')->find($id);
		$this->assign('detail_info',$detail_info);
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch('edit'),
		];
		return $re;
	}
	
		public function checkAjax()
		{
			if(request()->isAjax()){
				$admin_post=request()->post();
				$key=array_keys($admin_post)[0];
				
				if($admin_post[$key]==''){
					return array('static'=>'0','msg'=>'未提供参数');
				}
				
				$validate=validate('Rights');
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
			$id=input('id');
			if(db('staff_type')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	}
