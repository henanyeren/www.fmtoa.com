<?php
	namespace app\phone\controller;
	use think\Controller;

	class Email extends Controller{
		
		//返回发送页面
		public function getUsers()
		{
			
	        $mymodel=model('Admin');
	        $list=db('admin')->select();
			return json_encode(array('status'=>200,'data'=>$list));
		}
		
		//添加发送数据
		public function sendmail()
		{
			$data=[
				'email_from_id'=>input('email_from_id'),
				'email_to_id'=>input('email_to_id'),
				'email_title'=>input('email_title'),
				'email_content'=>input('email_content'),
				'email_addtime'=>time()
			];
			
			if(db('email')->insert($data)){
				return json_encode(array('status'=>200,'msg'=>'发送成功'));	
			}else{
				return json_encode(array('status'=>100,'msg'=>'发送失败'));
			}
			
		}
	

	//所有我的邮件
	public function myEmails()
	{

		
		$listInfo=db('Email')->where([
			'email_to_id'=>input('email_to_id'),
			])
		->alias('e')
		->join('oa_admin a','e.email_from_id=a.admin_id')			
		->paginate(10);

		$data=[];
		$list=$listInfo->toArray();

			foreach($list['data'] as $k=>$v){
				$v['email_addtime']=date('m-d H:i::s',$v['email_addtime']);
				array_push($data,$v);
			}			
		$list['data']=$data;
		return json_encode(array('status'=>200,'data'=>$list));

	}


	//我的发件箱
	public function outbox()
	{
		$listInfo=db('Email')->where([
			'email_from_id'=>input('email_from_id'),
			'email_is_del'=>0
			])
		->alias('e')
		->join('oa_admin b','e.email_to_id=b.admin_id')
		
		->paginate(10);
		$data=[];
		$list=$listInfo->toArray();
			foreach($list['data'] as $k=>$v){
				$v['email_addtime']=date('m-d H:i::s',$v['email_addtime']);
				array_push($data,$v);
			}			
		$list['data']=$data;
		return json_encode(array('status'=>200,'data'=>$list));


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
			
			$re=db('email')->where('email_id',$id)->update(['email_is_del'=>1]);
			if($re){
				return json_encode(array('status'=>200,'msg'=>'删除成功!'));	
			}else{
				return json_encode(array('status'=>100,'msg'=>'删除失败!'));	
			}
			
//			if(db('email')->where('email_id',$id)->update(['email_is_del'=>1])){
//				return 'sss';
//			}else{
//				return array('status'=>100,'msg'=>'删除失败!');	
//			}
		}
		
	//获取邮件箱请  fa
	public function detail_to()
	{
		$id=input('email_id');
		
		$detail=db('Email')
		->alias('e')
		->join('oa_admin a','e.email_to_id=a.admin_id')
		->where('email_id',$id)
		->field('email_id,email_from_id,email_to_id,email_title,email_file,email_hasfile,email_filename,email_content,email_addtime,email_is_read,email_is_del,admin_id,admin_duty_superid,alias')
		->find();
		
		$detail['email_addtime']=date('Y-m-d H:i',$detail['email_addtime']);
		
		if(!$detail['email_is_read']){
			if(!db('Email')->where('email_id',$id)->update(['email_is_read'=>1])){
				return array('state'=>'0','msg'=>'邮件状态	更新错误');
			}
		}
		
		if($detail){
			return json_encode(array('status'=>'200','data'=>$detail));
		}else{
			return json_encode(array('status'=>'100'));
		}
	}

    //shou
	public function detail_from()
	{
		$id=input('email_id');
		
		$detail=db('Email')
		->alias('e')
		->join('oa_admin a','e.email_from_id=a.admin_id')
		->where('email_id',$id)
		->field('email_id,email_from_id,email_to_id,email_title,email_file,email_hasfile,email_filename,email_content,email_addtime,email_is_read,email_is_del,admin_id,admin_duty_superid,alias')
		->find();
		
		$detail['email_addtime']=date('Y-m-d H:i',$detail['email_addtime']);
		
		if(!$detail['email_is_read']){
			if(!db('Email')->where('email_id',$id)->update(['email_is_read'=>1])){
				return array('state'=>'0','msg'=>'邮件状态	更新错误');
			}
		}
		
		if($detail){
			return json_encode(array('status'=>'200','data'=>$detail));
		}else{
			return json_encode(array('status'=>'100'));
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
