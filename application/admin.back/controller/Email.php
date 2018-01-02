<?php
	namespace app\admin\controller;
	use think\Controller;

	class Email extends Common{
		
		//返回发送页面
		public function send()
		{
			$this->assign([
				'tabTitle'=>'发送邮件',
				'admin_id'=>session('admin_id')
			]);	
        //人员分类
        $mymodel=model('Admin');
        $data=db('admin')->select();
        $mypid=$mymodel->adminchile($data);
        		
        		

		$this->assign([
            'pid'=>$mypid,
        ]);        		
        			
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			]; 
			return $re;
		}
		
		//添加发送数据
		public function addhanddle()
		{
			$data=request()->post();
			$validate=validate('Email');
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}
			
			
			$re=db('email')->insert($data);
			if($re){
				return array('state'=>1,'msg'=>'规则添加成功');
			}else{
				return array('state'=>0,'msg'=>'规则添加失败');
			}
			return ;
		}

	//未读邮件
	public function myUnknowMessage(){
		$list=db('Email')->where([
			'email_to_id'=>session('admin_id'),
			'email_is_read'=>0,
			'email_is_del'=>0
			])
		->alias('e')
		->join('oa_admin a','e.email_from_id=a.admin_id')			
		->paginate(10);
		
		$this->assign([
			'tabTitle'=>'未读消息',
			'list'=>$list,
		]);	
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch('my_unknow_message'),	
		];
		
		if(request()->isAjax()){
			return $re;
		}		
		
			
	}



	//所有我的邮件
	public function myEmails()
	{
	
	
		$list=db('Email')->where([
			'email_to_id'=>session('admin_id'),
			'email_is_del'=>0
			])
		->alias('e')
		->join('oa_admin a','e.email_from_id=a.admin_id')			
		->paginate(10);
				
		$this->assign([
			'list'=>$list,
		]);	
		$re=[
			'status'=>1,
			'page'=>$this->fetch('my_emails'),	
		];
		
		if(request()->isAjax()){
			return $re;
		}
	}

	//我的发件箱
	public function outbox()
	{
		$list=db('Email')->where([
			'email_from_id'=>session('admin_id'),
			'email_is_del'=>0
			])
		->paginate(10);
		$this->assign([
			'list'=>$list,
		]);			
				

		$re=[
			'status'=>1,
			'page'=>$this->fetch(),
		];
		if(request()->isAjax()){
			return $re;
		}
	}

	//上传发送数据
	public function replayAdd()
	{
			$data=request()->post();
			$validate=validate('Email');
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}
			
			
			$re=db('email')->insert($data);
			if($re){
				return array('state'=>1,'msg'=>'规则添加成功');
			}else{
				return array('state'=>0,'msg'=>'规则添加失败');
			}
			return ;
	}
	
	//返回发送数据
		public function replay()
		{
			$this->assign([
				'email_to_id'=>input('email_to_id'),
				'tabTitle'=>'回复'.input('from_admin_name').'的邮件',
				'admin_id'=>session('admin_id')
			]);	

			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			]; 
			return $re;
		}	
	

		public function del()
		{
			$id=input('email_id');
			if(db('Email')->where('email_id',$id)->update(['email_is_del'=>1])){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('id');
		
		$detail=db('Email')
		->alias('e')
		->join('oa_admin a','e.email_from_id=a.admin_id')
		->where('email_id',$id)
		->find();
		
		if(!$detail['email_is_read']){
			if(!db('Email')->where('email_id',$id)->update(['email_is_read'=>1])){
				return array('state'=>'0','msg'=>'邮件状态	更新错误');
			}
		}
		
		$this->assign('detail',$detail);
		if($detail){
			return array('state'=>'1','msg'=>$this->fetch());
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
	public function upload(){
		$file=request()->file('thumb');
		    // 移动到框架应用根目录/public/uploads/ 目录下
		    if($file){
		        $info = $file->move(ROOT_PATH . 'public' . DS . 'email');
		        if($info){
		            // 成功上传后 获取上传信息
		            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
		            return array('status'=>1,'msg'=>$info->getSaveName());
		        }else{
		            // 上传失败获取错误信息
		            return array('status'=>0,'msg'=>$file->getError());
		        }
		    }
		
	}
		
		
	}
