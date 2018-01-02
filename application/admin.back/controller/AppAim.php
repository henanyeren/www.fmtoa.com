<?php
	namespace app\admin\controller;
	use think\Controller;

	class AppAim extends Common{

		public function manager()
		{
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}

		public function add()
		{   
			$this->assign([
				'tabTitle'=>'添加目标',
			]);	
			$re=[
				'status'=>1,
				'page'=>$this->fetch('add'),
			]; 
			return $re;
		}

		//添加发送数据
		public function addhanddle()
		{

			$data=request()->post();
            
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}
			$data['aim_pid' ]=session('admin_id');
			$data['aim_time']=time();
			$re=db('app_aim')->insert($data);
			if($re){
				return array('state'=>1,'msg'=>'规则添加成功');
			}else{
				return array('state'=>0,'msg'=>'规则添加失败');
			}
			return ;
		}

		public function lst(){
			$list=model('AppAim')->order('aim_time desc')->paginate(10);
			foreach ($list as $v) {
				$data=$v->admin;
			}

			//dump($list->toarray());exit;
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'目标管理',
			]);	
			$re=[
				'status'=>1,
				'page'=>$this->fetch('lst'),
			];

			if(request()->isAjax()){
				return $re;
			}
	    }
	}