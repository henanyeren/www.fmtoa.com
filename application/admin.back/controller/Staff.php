<?php
	namespace app\admin\controller;
	use think\Controller;

	class Staff extends Common{
		
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
			unset($data['staff_job_id']);
			$validate=validate('Staff');
			
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}
            //var_dump($data);
			$re=db('Staff')->insert($data);

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
			$pids=db('Staff')->where('pid',$pid)->select();
		}
	
		
	public function lst()
	{

        $department_id=input('staff_duty_super_id');
        $where=[];
        if($department_id){
            $department_superid=db('duty')->find($department_id)['duty_super_id'];
            $where=[
                'staff_duty_super_id'=>$department_superid,
            ];

            $list=db('Staff')
                ->alias('s')
                ->join('oa_duty d','s.staff_duty_super_id=d.duty_super_id')

                ->field('staff_id,staff_name,d.duty_name,staff_sex')
                ->where($where)
                ->paginate(20);

            $this->assign('list',$list);
            $re=[
                'type'=>'list',
                'page'=>$this->fetch('lstSub'),
            ];
            return $re;
            die;
        }



        $list=db('duty')->select();
        $pids=model('duty')->getChildren($list);
			$list=db('Staff')
			->alias('s')
			->join('oa_duty d','s.staff_duty_super_id=d.duty_super_id')
			
			->field('staff_id,staff_name,d.duty_name,staff_sex')
			->paginate(20);
			
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'员工列表',
                'pids'=>$pids,
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
	public function checkAjax()
	{
		if(request()->isAjax()){
			$admin_post=request()->post();
			$key=array_keys($admin_post)[0];
			$validate=validate('Staff');
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
		$id=input('staff_id');
		if(db('Staff')->delete($id)){
			return array('state'=>1,'msg'=>'删除成功！');
		}else{
			return array('state'=>0,'msg'=>'删除失败!');	
		}
	}
		
	public function detail()
	{
	    $id=input('id');
		$detail=db('Staff')
		->alias('s')
		->join('oa_duty d','s.staff_duty_super_id=d.duty_super_id')
		->find($id);
		
		if($detail){
			$this->assign('detail',$detail);
			return array('state'=>'1','msg'=>$detail['staff_age'],'msg'=>$this->fetch('detail'));
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

	public function getStaffs(){
		$super_id=input('super_id');
		
		if($super_id){
			$list=db('admin')->where('admin_duty_superid',$super_id)->select();
			if($list){
				$this->assign('list',$list);
				return array('state'=>'1','page'=>$this->fetch());
			}else{
				return array('state'=>'0','msg'=>'该部门暂无人员');
			}
		}else{
			//未传值查找默认pid=1的
			
			$duty_pid=input('type_id')?input('type_id'):1;
			$list=db('duty')->where('duty_pid',$duty_pid)->select();
			if(!$list){
				if($duty_pid){
					$duty_superid=db('duty')->where('duty_id',$duty_pid)->find()['duty_super_id'];
		    		$staff_data=db('admin')->where('admin_duty_superid',$duty_superid)->select();
		    		
		    		//dump($staff_data	);
		    		$this->assign([
		    			//'materiel_data'=>$materiel_data,
		    			'list'=>$staff_data
		    			]);
		    		return array('state' => 2,'page_data' =>$this->fetch('page_data'));
	    							
				}

	    	}
	    	
	    	//dump($list);
	    	$this->assign([
	    		'list'=>$list,
	    		'materiel_data'=>'null'
	    	]);	    	
		   return array('state' =>1,'page' =>$this->fetch('page')); 	
		}
		return array('state'=>'0','msg'=>'找不到该部门');
		
	}
	}
