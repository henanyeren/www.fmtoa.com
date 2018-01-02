<?php
namespace app\phone\controller;
use think\Controller;

class AppLocation extends Controller{
	public function sign(){
    //签到

        $location_admin_id =input('location_admin_id');
        $location_addresses=input('location_addresses');
		$data['location_addresses']=$location_addresses;
		$data['location_latitude']=input('location_latitude');
		$data['location_longitude']=input('location_longitude');
		//$data['location_timestamp']=input('location_timestamp');
		$data['location_admin_id']=$location_admin_id;
        $data['location_timestamp']=time();

      //获取当天9点时间戳判断签到是否迟到
        $mytime=date('Y-m-d',$data['location_timestamp']);
        $time=strtotime($mytime."09:00:00");
        $data['location_day']=date('d',$data['location_timestamp']);
        if($data['location_timestamp']>$time){
            //签到状态  2迟到   1正常
            $data['location_state']=2;
        }else{
            $data['location_state']=1;
        }
        //判断是否签到
        if(isset($location_addresses)){
        	$stime=strtotime(date('Y-m-d', time()));
			$etime=strtotime(date('Y-m-d',strtotime("+1day",time())));
	        $state=db('AppLocation')->where('location_admin_id',$location_admin_id)
		                                            ->where('location_timestamp','>=',$stime)
		                                            ->where('location_timestamp','<',$etime)
		                                            ->find();
		    if($state==null){
	            db('AppLocation')->insert($data);
	            unset($data['location_state']);
	            unset($data['location_day']);
			    $position =[
			    	$data['location_longitude'],
			    	$data['location_latitude']
			    ];
			    //序列化
		        $data['position'] = serialize($position);
		        //位置图
		        $data['icon'] ='http://webapi.amap.com/theme/v1.3/markers/n/mark_b1.png';
				//$data['location_timestamp']=input('location_timestamp');
                $res=db('AppLocationPath')->insert($data);

	            if($res){
		            return json_encode(array('state'=>'200','msg'=>"签到成功"));
				}else{
		            return json_encode(array('state'=>'101','msg'=>"签到失败"));
				}

			}else{
	            return json_encode(array('state'=>'101','msg'=>"今日已签到"));
			}
			
        }else{
            return json_encode(array('state'=>'100','msg'=>"请重新提交"));
        }
		
		
	}



	public function sign_out(){
    //签退

        $location_admin_id =input('location_admin_id');
        $location_addresses=input('location_addresses');
		$data['location_addresses_end']=$location_addresses;
		$data['location_latitude_end']=input('location_latitude');
		$data['location_longitude_end']=input('location_longitude');
		//$data['location_timestamp']=input('location_timestamp');
        $data['location_timestamp_end']=time();
       
        //判断是否签退
        if(isset($location_addresses)){
        	$stime=strtotime(date('Y-m-d', time()));
			$etime=strtotime(date('Y-m-d',strtotime("+1day",time())));
	        $state=db('AppLocation')->where('location_admin_id',$location_admin_id)
		                                            ->where('location_timestamp','>=',$stime)
		                                            ->where('location_timestamp','<',$etime)
		                                            ->find();
		    if($state['location_timestamp_end']==null){
	            $res=db('AppLocation')->where('location_id',$state['location_id'])->update($data);
	            if($res){
		            return json_encode(array('state'=>'200','msg'=>"签退成功"));
				}else{
		            return json_encode(array('state'=>'101','msg'=>"签退失败"));
				}

			}else{
	            return json_encode(array('state'=>'101','msg'=>"今日已签退"));
			}
			
        }else{
            return json_encode(array('state'=>'100','msg'=>"请重新提交"));
        }
		
		
	}

	public function judge(){
        $location_admin_id=input('location_admin_id');
		
		$data['location_time']=strtotime(input('location_time'));

		$stime=strtotime(date('Y-m-d', time()));
		$etime=strtotime(date('Y-m-d',strtotime("+1day",time())));
        $res=db('AppLocation')->where('location_admin_id',$location_admin_id)
	                                            ->where('location_timestamp','>=',$stime)
	                                            ->where('location_timestamp','<',$etime)
	                                            ->find();
        
		if($res==null){
            return json_encode(array('state'=>'200','msg'=>"今日未签到"));
		}else{
            return json_encode(array('state'=>'101','msg'=>$res['location_timestamp_end'],'location_id'=>$res['location_id']));
		}
       
		
		
	}

	public function location(){
		$stime=strtotime(date('Y-m-d', time()));
		$etime=strtotime(date('Y-m-d',strtotime("+1day",time())));
        $state=db('AppLocation')/*->where('location_admin_id',$location_admin_id)
	                                            */->where('location_timestamp','>=',$stime)
	                                            ->where('location_timestamp','<',$etime)
	                                            ->find();
	    if($state){

			$location_admin_id =input('location_admin_id');
	        $location_addresses=input('location_addresses');
			$data['location_addresses']=$location_addresses;
			$data['location_latitude']=input('location_latitude');
			$data['location_longitude']=input('location_longitude');
			//定位坐标
			$position =[
		    	$data['location_longitude'],
		    	$data['location_latitude']
		    ];
		    //序列化
	        $data['position'] = serialize($position);
	        //位置图
	        $data['icon'] =input('icon');
			//$data['location_timestamp']=input('location_timestamp');
			$data['location_admin_id']=$location_admin_id;
	        $data['location_timestamp']=time();
	       
	        //判断
	        if(isset($location_admin_id)){ 
	        	
	            $res=db('AppLocationPath')->insert($data);
	            if($res){
		            return json_encode(array('state'=>'200','msg'=>"定位成功"));
				}else{
		            return json_encode(array('state'=>'101','msg'=>"定位失败"));
				}

				
				
	        }else{
	            return json_encode(array('state'=>'100','msg'=>"提交失败"));
	        }

        }else{
        	return json_encode(array('state'=>'100','msg'=>"还未签到"));
        }

	}
}