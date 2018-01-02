<?php
	namespace app\phone\controller;
	use think\Controller;

	class Logs extends Controller{
		//添加处理数据
		public function addhanddle()
		{
			$data=[
				'staff_title'=>input('staff_title'),
				'staff_content'=>input('logcon'),
				'staff_username'=>input('username'),
				'staff_admin_id'=>input('user_id'),
				'staff_log_time'=>time()
			];
			

			if(db('staffLog')->insert($data)){
				return json_encode(array('status'=>'200','msg'=>"提交成功"));
			}else{
				return json_encode(array('status'=>'100','msg'=>"提交失败"));
			}
			return ;
		}
		
		public function lst(){
		
			$id=input('user_id');
			$data=array();
			$listInfo=db('staff_log')->order('staff_id desc')->where('staff_admin_id',$id)->paginate(20);
			$list=$listInfo->toArray();
			foreach ($list['data'] as $key =>$value ){
			 $value['staff_log_time'] = date( 'Y-m-d H:i:s',$value['staff_log_time']);
            array_push($data,$value);
			}
			$list['data']=$data;
			if($list){
				$list['status']='200';	
			}
			
			
			return $re=json_encode($list);
		
		}	
		
		
		public function detail(){
			$id=input('staff_id');
            if(isset($id)){
                $detail=db('staff_log')->find($id);
                if($detail){
                    $detail['staff_log_time']=date('Y-m-d H:i:s',$detail['staff_log_time']);
                    return json_encode($detail);
                }else{
                    return json_encode(array('找不到你要日志'));
                }
               }else{
                return json_encode(array('参数错误！！'));
            }


			
			
		}	
		
		
	}
