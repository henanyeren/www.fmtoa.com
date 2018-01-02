<?php
	namespace app\admin\controller;
	use think\Controller;

	class Rights extends Common{
		
		public function add()
		{
			$list=db('auth_rule')->select();
			$pids=model('AuthRule')->getChildren($list);
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
				'pid'=>input('pid'),
				'name'=>input('name'),
				'title'=>input('title'),
			];
			
			dump($data);
			$validate=validate('Rights');
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}
			$re=db('auth_rule')->insert($data);
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
		$pids=db('auth_rule')->where('pid',$pid)->select();
	}
	
		
	public function lst()
	{
			$list=model('AuthRule')->getChildren(db('auth_rule')->select());
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'规则列表',
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
		$detail_info=db('auth_rule')->find($id);
		$this->assign('detail_info',$detail_info);
		//获取无限极分类
			$list=db('auth_rule')->select();
			$pids=model('AuthRule')->getChildren($list);
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
			'id'=>input('id'),
			'name'=>input('name'),
			'title'=>input('title'),
			'pid'=>input('pid'),
		];
		
		$validate=validate('Rights');
		if(!$validate->scene('add')->check($data)){
			$this->error($validate->getError());
		}
		$re=db('auth_rule')->where('id',$data['id'])->update($data);
		if($re){
			return array('state'=>1,'msg'=>'规则添加成功');
		}else{
			return array('state'=>0,'msg'=>'规则添加失败');
		}
		
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
			if(db('auth_rule')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function groupadd()
	/*添加规则界面*/
	{
		$rule_select = db('auth_rule')->where('status','eq','1')->select();
		$auth_rule_model = model('AuthRule');
		$rule_in = $auth_rule_model->getChildren($rule_select);
		$this->assign('rule_in',$rule_in);
		
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
	}
	
	public function groupaddhanddle()
	/*添加用户组提交方法处理*/
	{
		$post = request()->post();
	
		$post['rules'] = $post['rules'];

		$group_add_result = db('auth_group')->insert($post);
		if ($group_add_result) {
			return array('state'=>1,'msg'=>'规则添加成功');
		}
		else{
					return array('state'=>0,'msg'=>'规则添加失败');
		}
		
	}
	
	
	public function grouplist()
	/*用户组列表*/
	{
		$group_select = db('auth_group')->select();
		foreach ($group_select as $key => $value) {
			$rules = db('auth_rule')->where('id','in',$value['rules'])->where('status','eq','1')->select();
			$group_select[$key]['rules'] = $rules;
			}
		$this->assign('group_select',$group_select);
		
			
		$this->assign([
			'group_select'=>$group_select,
			'tabTitle'=>'用户组列表',
			]);
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch('grouplist'),
		];
		return $re;
	}
	
	public function groupupd($id="")
	/*用户组修改界面显示*/
	{
		$id=input('id');
		$group_find = db('auth_group')->find($id);
		if (empty($group_find)) {
			$re=[
				'status'=>0,
				'page'=>'错误，不能为空id',
			];
			return $re;
		}
		
		$group_find['rules'] = explode(',',$group_find['rules']);
		
		$rule_select = db('auth_rule')->select();
		$auth_rule_model = model('AuthRule');
		$rule_in = $auth_rule_model->getChildren($rule_select);
		$this->assign([
			'rule_in'=>$rule_in,
			'group_find'=>$group_find,
			
			]);
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch(),
		];
		return $re;
	}	
	
	public function groupupdhanddle()
	/*修改用户组提交处理方法*/
	{
		$post = request()->post();
	
		$post['rules'] = $post['rules'];
		$id=$post['id'];
		unset($post['id']);
		$group_add_result = db('auth_group')->where('id',$id)->update($post);
		if ($group_add_result) {
			return array('state'=>1,'msg'=>'规则添加成功');
		}
		else{
					return array('state'=>0,'msg'=>'规则添加失败');
		}
	}
	
	//删除权限组
	public function groupdel()
	{
		$id=input('id');
		if(db('auth_group')->delete($id)){
			return array('state'=>1,'msg'=>'删除成功！');
		}else{
			return array('state'=>0,'msg'=>'删除失败!');	
		}
	}


	public function adminadd1(){

         $id=   input('id');
         $mydate=db('staff')->where('staff_duty_super_id','like',$id.'%')
             ->field('staff_id,staff_name,staff_duty_super_id')->select();

         $this->assign([
                'mydate'=>$mydate,
            ]);
            $re=[
                'status'=>1,
                'page'=>$this->fetch('adminmyname'),
            ];
            return $re;



    }


	public function adminadd()
	/*添加管理员界面显示*/
	{
        //人员分类
       /* $mymodel=model('Admin');
        $data=db('admin')->select();
        $mypid=$mymodel->adminchile($data);
		$group_select = db('auth_group')->where('status','eq','1')->select();*/
        $mymodel=model('Duty');
        $data=db('duty')->select();
        $mypid=$mymodel->getChildren($data);
        $group_select = db('auth_group')->where('status','eq','1')->select();
        $adds=db('distribution_area')->select();
        $add=model('Distribution')->getChildren($adds);
		$this->assign([
		    'group_select'=>$group_select,
            'pid'=>$mypid,
            'add'=>$add
        ]);
        
		$re=[
			'status'=>1,
			'page'=>$this->fetch(),
		];
		return $re;
	}

	public function adminaddhanddle()
	/*添加管理员提交处理方法*/
	{
		if (request()->isPost()) {
			$post = request()->post();
			$validate = validate('Admin');
			if (!$validate->check($post)) {
				$this->error($validate->getError());
			}
			unset($post['admin_password1']);
			$group_id=$post['group_id'];
			unset($post['group_id']);
			//调用密码函数
			$model=model('admin');
			$pwd_re=$model->getNewPwd($post['admin_password']);
			$post['admin_password'] = $pwd_re['newPwd'];
			
			$post['admin_random_number'] = $pwd_re['random'];
			

			$admin_add_result = db('admin')->insertGetId($post);
			if ($admin_add_result) {
				
				//分配权限
				$oa_auth_group_access_data=array('uid'=>$admin_add_result,'group_id'=>$group_id);
				if(!db('authGroupAccess')->insert($oa_auth_group_access_data)){
					return array('state'=>0,'msg'=>'权限分配错误');
				}
				return array('state'=>1,'msg'=>'规则添加成功');
			}
			else{
				return array('state'=>0,'msg'=>'规则添加失败');
			}
		}
	}
	
	
	public function adminlist()
	/*管理员列表*/
	{
		$admin_select = db('admin')->select();
		$this->assign([
			'group_select'=>$admin_select,
			'tabTitle'=>'',
		]);
		
		$re=[
			'status'=>1,
			'page'=>$this->fetch(),
		];
		return $re;
		
	}
	
	public function adminupd()
	/*管理员修改界面显示*/
	{
        $admin_id=input('id');

        $admin_model = model('Admin');
        $admin_get = $admin_model->get($admin_id);
        
        //获取关联的权限组
        $auth_group_access=db('auth_group_access')->where('uid',$admin_id)->find();
        if (empty($admin_get)) {
            $re=[
                'status'=>1,
                'page'=>'错误，不能为空id',
            ];
            return $re;
        }
        $auth = new Auth();
        $group_ids = $auth->getGroups($admin_id);
        
        $group_select = db('auth_group')->where('status','eq','1')->select();

        $this->assign([
        	'group_select'=>$group_select,
        	'group_id'=>$auth_group_access['group_id'],
        	'admin_find'=>$admin_get->toArray()
        ]);

        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        return $re;
		
	}
	
	public function adminupdhanddle()
	/*添加管理员提交处理方法*/
	{
		$post = request()->post();
		if ($post) {
			//收集数据
			$data=[];
			//如果上传密码的话就修改收集密码
			if($post['admin_password']){
				$validate = validate('Admin');
				if (!$validate->check($post)) {
					return $validate->getError();
				}
				
				//调用model 获取密码和随机数
				
				$model=model('admin');
				$pwd_re=$model->getNewPwd($post['admin_password']);
				$post['admin_password'] = $pwd_re['newPwd'];
				
				$data['admin_random_number'] = $pwd_re['random'];
					
				$data['admin_password']=$post['admin_password'];
			}
			
			$data['admin_name']=$post['admin_name'];
			$data['admin_id']=$post['admin_id'];
			//返回信息
			$msg='规则添加成功';
			
			if(!db('admin')->where('admin_id',$post['admin_id'])->update($data)){
				$msg='权限更新成功！管理员信息未改动';
			}
				//分配权限
			if(!db('authGroupAccess')->where('uid',$post['admin_id'])->update(['group_id'=>$post['group_id']])){
				$msg='权限分配错误';
				return array('state'=>0,'msg'=>$msg);
			}				
			return array('state'=>1,'msg'=>$msg);
		}
	}	
	

	public function admin_del(){
		
		$id=input('id');
		if(db('admin')->delete($id)){
			
			return array('state'=>1,'msg'=>'管理员删除成功');
		}
		return array('state'=>0,'msg'=>'管理员删除失败');
	}

        public function dump(){
            $filename="王永生.xlsx";//第一个参数必须是文件名  后缀名以xlsx结尾
            $list =db('admin')->select();   //第三个参数未数据库查出来的数据   必须是二维数组
            $headArr=[                         //第二个参数是表头   必须和数据表内容一致    必须是一维数组
                'ID',
                '姓名',
                '别名',
            ];
            $this->NP_Excel($filename,$headArr,$list);
        }

	}
