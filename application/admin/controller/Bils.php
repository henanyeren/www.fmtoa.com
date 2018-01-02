<?php
	namespace app\admin\controller;
	use think\Controller;

	class Bils extends Common{
	
		public function manager(){
			
			$re=[
				'state'=>1,
				'page'=>$this->fetch(),
			];
			return $re;
		}		
		
		//查寻
		public function search(){
			$where=[];
			//$id=1;
			
			//初始化开始和结束时间
			$startTime='';
			$endTime='';
			if(input('start_time')){
				$startTime=strtotime(input('start_time'));
							
			}
			if(input('end_time')){
				$endTime=strtotime(input('end_time'));
			}

			//如果存在就保存
			if($startTime){
				session('startTime',$startTime);
			}else{
				$startTime=session('startTime');
			}
			
			if($endTime){
				session('endTime',$endTime);
			}else{
				$endTime=session('endTime');
			}
			
			if($startTime&&$endTime){
				$where['materiel_add_time']=['between',[$startTime,$endTime]];
			}			
			
			$id=input('key');
			if($id){
				session('materiel_id',$id);
			}else{
				$id=session('materiel_id');
			}
			if($id){
				$where['materiel_id']=['like',"%$id%"];
				
			}
						

			
			//dump($where);
					
			$list=db('depot_press_materiels')
			//->where($where)
			->whereOr($where)
			
			->order('materiel_id','desc')
			->paginate(10);
			$this->assign('list',$list);
			
			
			
			$re=[
				'state'=>1,
				'page'=>$this->fetch(),
			];
			return $re;			
		}
		
		
		//获取详情
		public function detail(){
			
			$materiel_id=input('id');
			$DepotPress_model=model('DepotPress');
			$data=$DepotPress_model->DepotPress($materiel_id);
			//dump($materiel_info);
			
			$this->assign('data',$data);
				//获取返回表单名，进行填充数据
				$type_table_name=db('depot_press_type')->where(
					[
						'type_number'=>$data['materiel_type'],
						'type_is_in'=>0
					]	
				)->find()['type_name'];	
			$re=[
					'state'=>1,
					'msg'=>$this->fetch('depot_press/'.$type_table_name)
				];	
			return $re;
			
			
		}
		
	}
