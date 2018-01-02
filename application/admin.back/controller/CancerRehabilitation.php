<?php
	namespace app\admin\controller;
	use think\Controller;
  
	class CancerRehabilitation extends Common{
		
		public function add()
		{
			//$pids=$this->getLevelChild();
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
			    'cancer_name'=>input('cancer_name'),
                'cancer_title'=>input('cancer_title'),
                'cancer_content'=>input('cancer_content'),
            ];


			$files=DS."case".DS.$data['cancer_name'].time().'.doc';
			$file="public".$files;
			$this->words($data['cancer_content'],$file);
			$data['cancer_file']=$files;


			$validate=validate('CancerRehabilitation');
			if(!$validate->scene('add')->check($data)){
				$this->error($validate->getError());
			}

			$re=db('CancerRehabilitation')->insert($data);
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
		$pids=db('CancerRehabilitation')->where('pid',$pid)->select();
	}
	
		
	public function lst()
	{
			$list=db('CancerRehabilitation')->paginate();
			
			$this->assign([
				'list'=>$list,
				'tabTitle'=>'肿瘤康复列表',
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
		$detail_info=db('CancerRehabilitation')->find($id);
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
		$data=[
				'cancer_id'=>input('cancer_id'),
				'cancer_name'=>input('cancer_name'),
				'cancer_title'=>input('cancer_title'),
				'cancer_content'=>input('cancer_content'),
        ];

        $files=DS."case".DS.$data['cancer_name'].time().'.doc';
        $file="public".$files;
        $this->words($data['cancer_content'],$file);
        $data['cancer_file']=$files;

		$id=$data['cancer_id'];
		unset($data['cancer_id']);
		$validate=validate('CancerRehabilitation');
		if(!$validate->scene('add')->check($data)){
			$this->error($validate->getError());
		}
		$re=db('CancerRehabilitation')->where('cancer_id',$id)->update($data);
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
				
				
				$validate=validate('CancerRehabilitation');
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
			$id=input('cancer_id');
			if(db('CancerRehabilitation')->delete($id)){
				return array('state'=>1,'msg'=>'删除成功！');
			}else{
				return array('state'=>0,'msg'=>'删除失败!');	
			}
		}
		
		
	public function detail()
	{
		$id=input('cancer_id');
		$detail=db('cancer_rehabilitation')->find($id);
		if($detail){
			return array('state'=>'1','msg'=>$detail['cancer_content'],'name'=>$detail['cancer_name']);
		}else{
			return array('state'=>'0','msg'=>'查询错误');
		}
	}

        public function uploads(){
// 获取表单上传文件 例如上传了001.jpg
            $finance = request()->file('thumb');
            $finance_img="public".DS."case";
            $finances_img=DS."case";
            $info_img = $finance->move(ROOT_PATH .$finance_img);
            if($info_img){
                $address=$finances_img.DS.$info_img->getSaveName();
                $b[0]="<script>alert('文件上传成功！');</script>";
                $b[1]=$address;
                return $b;
            }else{
                $b[0]="<script>alert('文件上传失败请重试！');</script>";
                $b[1]=0;
                return $b;
            }
        }


	}
