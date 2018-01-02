<?php
	namespace app\admin\controller;
	use think\Controller;
	
	class Routine extends Common{
		
		public function untreated(){
			$untreated_arr=[];
			//获取所属部门信息
			$duty_info=db('duty')->where('duty_super_id',session('admin_duty_superid'))->find();
			//获取事务查找 指定 表群
			$tables=db('flow_tables')->where('table_id',$duty_info['duty_flow_tables_id'])->find()['table_weights_names'];
			$table_arr=explode(',',$tables);
			$arr=[];
			//循环处理表
			foreach($table_arr as $k=>$v){
				if($v){
					//获取未处理事务数量
					$requisitionl_flow_lines=db($v)->where('requisition_is_end',0)->select();
					if($requisitionl_flow_lines){
						//得到所有未处理的行事务
						foreach($requisitionl_flow_lines as $k1=>$v1){
							$v1_index=$v1;
							//用于获取数据id
							$id=array_values($v1_index)[0];
							$add_time=array_values($v1_index)[1];
							
							$v1['id']=$id;
							$v1['add_time']=$add_time;
							//获取行内的流程列
							//查询提交者姓名
							$v1['admin_alias']=db('admin')->find($v1['requisition_from_id'])['alias'];
							
							//查询提交者所属部门
							$v1['admin_duty_name']=db('duty')->where('duty_super_id',$v1['requisition_super_id'])->find()['duty_name'];
							$requisitionl_flow_sub_arr=explode(',',$v1["requisitionl_flow"]);
								//遍历得出事务流程的所有id，判断是否很管理员部门ID相同，如果相同
								foreach($requisitionl_flow_sub_arr as $k2=>$v2){
									if($k2==0){
										if($v2==$duty_info['duty_id']){
										$untreated_arr[$k]['table_name']=$v;
										$untreated_arr[$k]['table_data'][$k1]=$v1;
										$untreated_arr[$k]['table_title']=$v1['table_title'];
										}								
									}else{
										if($v2==$duty_info['duty_id']&&!$requisitionl_flow_sub_arr[$k2-1]){
										$untreated_arr[$k]['table_name']=$v;
										$untreated_arr[$k]['table_data'][$k1]=$v1;
										$untreated_arr[$k]['table_title']=$v1['table_title'];
										}								
									}									
								}
						}						
					}
				}
			}
			if(!$untreated_arr){
				return array('status'=>0,'page'=>'暂无未处理事务！');
			}
			$this->assign([
				'tabTitle'=>'未处理事务',
				'untreated_arr'=>$untreated_arr
			]);
			$re=[
				'status'=>1,
				'page'=>$this->fetch(),
			]; 
			return $re;
		}
		

	
	
	
	public function detail()
	{
			
		$table_id=input('target_id');
		
		$routine_model=model('DepotPressMateriels');
		$data_info=$routine_model->get($table_id);
		$data_info->MyRoutine;
		$data_arr=$data_info->toArray();
		//把数据库类名读取 执行字符串
		$str = "<?php 	
				namespace app\admin\controller;
				\$my_controller= new ".$data_arr['MyRoutine']['routine_controller_name']."()"."; 
				";
		eval( '?>' . $str ); 

		$re_info=$my_controller->detail($table_id);
		return $re_info;
	}
		
	
	//执行处理
	public function approval(){
		$toTable=input('toTable');
		$requisition_message=input('requisition_message');
		//dump($requisition_refuse_message);
		$approval_result=input('approval-result');
		$table_id=input('tableId');
		$this->routineCB($table_id);
		//调用方法把批文保存

		
		//如果表存在
		if(!$toTable){
			return array('state'=>'0','msg'=>$toTable.'表不存在');
		}
		
		$requisitionl_info=db($toTable)->find($table_id);
		$requisitionl_flow=	$requisitionl_info['requisitionl_flow'];			
		//获取我的事务表，对应的id
		$requisitionl_routine_id=$requisitionl_info['requisitionl_routine_id'];		
	
		//获取其中我的事务数据，用于处理数据审核
		$requisitionl_routine_info=db('my_routine')->find($requisitionl_routine_id);
			
		//用于保存批文	
		$re=$this->saveMessage($toTable,$table_id,$requisition_message,$approval_result);
		if(!$re){
			return array('state'=>'2','msg'=>'批文保存失败');
		}	
			
				
		if($approval_result){


			//获取
			$new_requisitionl_flow=str_replace(session('duty_id'),0,$requisitionl_flow);
			$routine_field_name=$requisitionl_routine_info['routine_field_name'];
			
			//获取更新主键id名称
			$routine_id_name	=$requisitionl_routine_info['routine_id_name'];
			//判断是否有需要更新的字段
			if(!$routine_field_name){
				
				$reset_re=db($toTable)->where($requisitionl_routine_info['routine_id_name'],$table_id)
					->update([
							'requisitionl_flow'=>$new_requisitionl_flow,
						]);
			}else{
				$reset_re=db($toTable)->where($routine_id_name,$table_id)
					->update([
							'requisitionl_flow'=>$new_requisitionl_flow,
							$routine_field_name=>session('admin_id')
						]);
			}
			$new_requisitionl_flow_arr=explode(',',$new_requisitionl_flow);
			//dump($new_requisitionl_flow_arr);
			 //如果执行完毕终结事务流
			if(!array_pop($new_requisitionl_flow_arr)){
				
				$end_re=db($toTable)->where($requisitionl_routine_info['routine_id_name'],$table_id)->update([
					'requisition_is_end'=>1,
					'requisition_refuse_id'=>session('admin_id')
				]);
				return array('state'=>'1','msg'=>'审核流程结束');
			}			
			//处理当前事务流中的 本部门置0
			if($reset_re){
				return array('state'=>'1','msg'=>'本部门审核完毕');
			}
			
		}else{
			$re=db($toTable)->where($requisitionl_routine_info['routine_id_name'],$table_id)->update([
					'requisition_is_end'=>1,
					'requisition_refuse_id'=>session('admin_id')
			]);
		
			
			return array('state'=>-1,'msg'=>'审批驳回成功');		
		}
		

		
	}
	
	//事务回掉函数
	public function routineCB($table_id){
		$routine_model=model('DepotPressMateriels');
		$data_info=$routine_model->get($table_id);
		$data_info->MyRoutine;
		$data_arr=$data_info->toArray();
		//把数据库类名读取 执行字符串
		$str = "<?php 	
				namespace app\admin\controller;
				\$my_controller= new ".$data_arr['MyRoutine']['routine_controller_name']."()"."; 
				";
		eval( '?>' . $str ); 
		$re_info=$my_controller->routineCB($table_id);
		return $re_info;


	}
	
	public function saveMessage($table_name,$table_id,$message,$approval_result){
		//参数$approval_result保存审核状态，用于记录是否通过，体现在前台，审批不通过的话，会以红色提示，更友好
		
		//获取当前登陆者信息
		$Routine_model=model('Routine');
		//$$Routine_model->get(session('admin_id'));
		
		$admin_alias=session('admin_alias');
		
		
		$data=[
			'flow_admin_alias'=>session('admin_alias'),
			'flow_admin_duty_name'=>session('duty_name'),
			'flow_is_state'=>$approval_result,
			
			
			'flow_table_name'=>$table_name,
			'flow_to_id'=>$table_id,
			'flow_message'=>$message,
			'flow_write_admin_id'=>session('admin_id'),
			'add_time'=>time()
		];
		//dump($data);die;
		if(db('flow_messages')->insert($data)){
			return true;
		}else{
			return false;
		}
	}
	
	//我的事务
	public function myRoutine(){
		$duty_routine_id=db('duty')->find(session('duty_id'))['duty_routine_id'];
		
		$routine_tables=db('my_routine')->find($duty_routine_id)['routine_tables'];
		$routine_tables_arr=explode(',',$routine_tables);
		
		//定义一个输出数组
		$untreated_arr=[];
		
		foreach($routine_tables_arr as $k=>$v){
			$sub_list=db($v)->where('requisition_from_id',session('admin_id'))->select();
			$third_list=[];
			foreach($sub_list as $k1=>$v1){
				$v1_index=$v1;
				//用于获取数据id
				$id=array_values($v1_index)[0];
				$add_time=array_values($v1_index)[1];
				$v1['id']=$id;	
				$v1['add_time']=$add_time;	
				$v1['table_name']=$v;
				//获取数据包的title

				$where=[
					'type_number'=>$v1['materiel_type']
				];
				
				if(!$v1['materiel_is_in']){
					$where=[
						'type_is_in'=>$v1['materiel_is_in'],
					];
				}				
				
				$table_title=db('depot_press_type')->where($where)->find()['type_alias'];
				$v1['table_title']=$table_title;
				$third_list[$k1]=$v1;	
			}
			//dump($third_list);
			$sub_list=$third_list;
			array_push($untreated_arr,$sub_list);
		}
		if(!$untreated_arr){
			return array('status'=>0,'page'=>'暂无未处理事务！');
		}
		
		$this->assign([
			'tabTitle'=>'未处理事务',
			'untreated_arr'=>$untreated_arr
		]);
		$re=[
			'status'=>1,
			'page'=>$this->fetch(),
		]; 
		return $re;
		
	}
	
	//流程信息
	public function FlowMessage(){
		//回去表明和id保存到批文表
		$target_table=input('target_table');
		$target_id=input('target_id');
		$where=[
			'flow_table_name'=>$target_table,
			'flow_to_id'=>$target_id,
		];
		
		$msg_list=db('flow_messages')->where($where)->select();
		$this->assign('list',$msg_list);
		
		$re=[
			'state'=>1,
			'page'=>$this->fetch(),
		]; 
		return $re;
	}
			
}
