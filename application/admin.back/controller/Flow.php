<?php
	namespace app\admin\controller;
	use think\Controller;

	class Flow extends Common{
		
		public function add()
		{

            $list=db('duty')->select();
            $pids=model('duty')->getChildren($list);
			$this->assign([
				'tabTitle'=>'添加新员工',
				'pids'=>$pids
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
			$data['flow_weights']=ltrim($data['flow_weights'],',');
			$re=db('flow')->insert($data);

			if($re){
				return array('state'=>1,'page'=>'添加成功');
			}else{
				return array('state'=>0,'page'=>'添加失败');
			}
			
			return ;
		}
	
		public function getLevelChild($pid=0)
		{
			$new_pid=input('pid');
			$pid=$new_pid?$new_pid:0;
			$pids=db('Staff')->where('pid',$pid)->select();
		}
	
		
	public function lst()
	{

		$list=db('flow')->paginate(10);
		$this->assign('list',$list);
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
        $list=db('duty')->select();
        $pid_list=model('duty')->getChildren($list);
		$detail_info=db('Staff')->find($id);
        $this->assign([
              'detail_info'=>$detail_info,
				'pids'=>$pid_list
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
		$data=request()->post();
		$id=$data['staff_id'];

		$validate=validate('Staff');
		if(!$validate->scene('add')->check($data)){
			$this->error($validate->getError());
		}
		unset($data['staff_id']);
		$re=db('Staff')->where('staff_id',$id)->update($data);
		if($re){
			return array('state'=>1,'msg'=>'修改成功');
		}else{
			return array('state'=>0,'msg'=>'修改失败');
		}
	}

	//查看详情
	public function detail()
	{
		$obj=model('flow');
		$info=$obj->get(input('id'));
		$info_detail=$info->toArray();
		
        $flow_weights=db('flow')->find(input('id'))['flow_weights'];
		$where='duty_id in('.$flow_weights.')';
		
		$da=db('duty')->where($where)->select();
		$info_detail['dutys']=$da;
		//dump($info_detail);
		
		$this->assign('detail',$info_detail);
		
		return array('state'=>1,'msg'=>$this->fetch());
	}

	//删除
	public function del()
	{
		if(db('flow')->delete(input('id'))){
			return array('state'=>1,'msg'=>'删除成功！');
		}else{
			return array('state'=>0,'msg'=>'删除失败！');
		}
	}
}
