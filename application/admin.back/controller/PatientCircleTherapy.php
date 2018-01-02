<?php
	namespace app\admin\controller;
	use think\Controller;

	class PatientCircleTherapy extends Common{
		
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
			$data=[
			    'patiend_name'=>input('patiend_name'),
                'patiend_sex'=>input('patiend_sex'),
                'patiend_age'=>input('patiend_age'),
                'patiend_nation'=>input('patiend_nation'),
                'patiend_marriage'=>input('patiend_marriage'),
                'patiend_profession'=>input('patiend_profession'),
                'patiend_work_addr'=>input('patiend_work_addr'),
                'patiend_tel'=>input('patiend_tel'),
                'patiend_allergy'=>input('patiend_allergy'),
                'patiend_visi_time'=>input('patiend_visi_time'),
                'patiend_main_desc'=>input('patiend_main_desc'),
                'patiend_doctor_signature'=>input('patiend_doctor_signature'),
                'patiend_disease_history'=>str_ireplace("\"","'",input('patiend_disease_history')),
                'patiend_previous_history'=>str_ireplace("\"","'",input('patiend_previous_history')),
                'patiend_menstrual_history'=>str_ireplace("\"","'",input('patiend_menstrual_history')),
                'patiend_family_history'=>str_ireplace("\"","'",input('patiend_family_history')),
                'patiend_tcm'=>str_ireplace("\"","'",input('patiend_tcm')),
                'patiend_physical_examination'=>str_ireplace("\"","'",input('patiend_physical_examination')),
                'patiend_accessory_examination'=>str_ireplace("\"","'",input('patiend_accessory_examination')),
                'patiend_tcm_diagnosis'=>str_ireplace("\"","'",input('patiend_tcm_diagnosis')),
                'patiend_western_diagnosis'=>str_ireplace("\"","'",input('patiend_western_diagnosis')),
                'patiend_therapeutic_opinion'=>str_ireplace("\"","'",input('patiend_therapeutic_opinion')),
            ];

			$re=db('PatientCircleTherapy')->insert($data);
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
			$pids=db('PatientCircleTherapy')->where('pid',$pid)->select();
		}


	public function lst()
	{
			$list=db('PatientCircleTherapy')->field('patiend_id,patiend_name,patiend_age,patiend_main_desc')->paginate(15);

			$this->assign([
				'list'=>$list,
				'tabTitle'=>'患者病例列表',
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
		$detail_info=db('PatientCircleTherapy')->find($id);
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
        $post=[
            'patiend_name'=>input('patiend_name'),
            'patiend_sex'=>input('patiend_sex'),
            'patiend_age'=>input('patiend_age'),
            'patiend_nation'=>input('patiend_nation'),
            'patiend_marriage'=>input('patiend_marriage'),
            'patiend_profession'=>input('patiend_profession'),
            'patiend_work_addr'=>input('patiend_work_addr'),
            'patiend_tel'=>input('patiend_tel'),
            'patiend_allergy'=>input('patiend_allergy'),
            'patiend_visi_time'=>input('patiend_visi_time'),
            'patiend_main_desc'=>input('patiend_main_desc'),
            'patiend_doctor_signature'=>input('patiend_doctor_signature'),
            'patiend_disease_history'=>str_ireplace("\"","'",input('patiend_disease_history')),
            'patiend_previous_history'=>str_ireplace("\"","'",input('patiend_previous_history')),
            'patiend_menstrual_history'=>str_ireplace("\"","'",input('patiend_menstrual_history')),
            'patiend_family_history'=>str_ireplace("\"","'",input('patiend_family_history')),
            'patiend_tcm'=>str_ireplace("\"","'",input('patiend_tcm')),
            'patiend_physical_examination'=>str_ireplace("\"","'",input('patiend_physical_examination')),
            'patiend_accessory_examination'=>str_ireplace("\"","'",input('patiend_accessory_examination')),
            'patiend_tcm_diagnosis'=>str_ireplace("\"","'",input('patiend_tcm_diagnosis')),
            'patiend_western_diagnosis'=>str_ireplace("\"","'",input('patiend_western_diagnosis')),
            'patiend_therapeutic_opinion'=>str_ireplace("\"","'",input('patiend_therapeutic_opinion')),
        ];
		$id=input('patiend_id');

		$re=db('PatientCircleTherapy')->where('patiend_id',$id)->update($post);
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
				
				
				$validate=validate('PatientCircleTherapy');
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
			$id=input('patiend_id');
			if(db('PatientCircleTherapy')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('id');
		$detail=db('PatientCircleTherapy')->find($id);

		//查询圈疗
		//$patiend_circles=$detail['patiend_circles'];
        //$patiend_circles_arr=explode(',',$patiend_circles);
		//$arr=db('circle_therapys')->where('circle_id','in', $patiend_circles_arr)->select();
		
		
		

		$this->assign([
			'detail'=>$detail,

		]);
		if($detail){
			return array('state'=>'1','msg'=>$this->fetch(),'name'=>'患者病例列表');
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
			
	}
	
	public function addCircle()
	{
		$id=input('id');
		$circle_content=input('circle_content');
		//dump(request()->post());
		if($circle_content){
			$model=model('CircleTherapys');
			$model->circle_name=input('circle_name');
			
			$model->circle_content=input('circle_content');
			$model->save();
			$circle_id=','.$model->circle_id;
			$patiend_circles=db('PatientCircleTherapy')->field('patiend_circles')->find($id)["patiend_circles"];
			$new_patiend_circles=ltrim($patiend_circles.$circle_id,',');
			$data=[
				'patiend_circles'=>$new_patiend_circles,
			];
			
			$getid=input('patiend_id');
			
			if(db('PatientCircleTherapy')->where('patiend_id',$getid)->update($data)){
			$re=[
				'state'=>1,
				//'page'=>$this->fetch('lst'),
			];
			
			return $re;
			}else{
			$re=[
				'state'=>0,
				'msg'=>'更新失败',
			];
			
			return $re;				
			};
			
			
		}
			$this->assign('patiend_id',$id);
			$re=[
				'state'=>1,
				'page'=>$this->fetch('addCircle'),
			];
			
			return $re;
	
		
	}
		
		
	}
