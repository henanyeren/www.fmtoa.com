<?php
	namespace app\admin\controller;
	use think\Controller;

	class AppNotice extends Common{
		
		public function add()
		{
			$this->assign([
				'tabTitle'=>'添加公告',
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
			
			$data['app_time']=time();
			$re=db('AppNotice')->insert($data);
			
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
			$pids=db('AppNotice')->where('pid',$pid)->select();
		}
	
		
	public function lst()
	{
			$list=db('AppNotice')->paginate(10);
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'公告列表',
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
		$detail_info=db('AppNotice')->find($id);
		$this->assign([
		    'detail_info'=>$detail_info
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
	    //var_dump(input('post.'));die;
		$data=[
		    'app_notice_state'=>input('app_notice_state'),
				'app_id'=>input('app_id'),
				'app_name'=>input('app_name'),
				'app_title'=>input('app_title'),
				'app_preview'=>input('app_preview'),
				'app_content'=>input('app_content'),
             //  'app_department_superid'=>input('app_department_superid'),
			];
			
			
		$id=$data['app_id'];
		unset($data['app_id']);
		$validate=validate('AppNotice');
		if(!$validate->scene('add')->check($data)){
			$this->error($validate->getError());
		}
		$re=db('AppNotice')->where('app_id',$id)->update($data);
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
				
				
				$validate=validate('AppNotice');
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
			$id=input('app_id');
			if(db('AppNotice')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('id');
		
		$detail=db('AppNotice')->find($id);
		if($detail){
			$this->assign('detail',$detail);
			return array('state'=>'1','msg'=>$this->fetch(),'name'=>$detail['app_name']);
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}
		
	public function upload(){
    // 获取表单上传文件 例如上传了001.jpg
		    $file = request()->file('thumb');
		    // 移动到框架应用根目录/public/uploads/ 目录下
		    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
		    if($info){
		        // 成功上传后 获取上传信息
		        // 输出 jpg
		        $address =DS.'uploads'.DS.$info->getSaveName();
		        return $address;
		    }else{
		        // 上传失败获取错误信息
		        echo $file->getError();
		    }
		}
		
	}
