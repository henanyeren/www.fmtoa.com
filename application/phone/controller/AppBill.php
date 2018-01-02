<?php
namespace app\phone\controller;
use think\Controller;
class AppBill extends Controller{
	//账单展示
	//账单列表
	public function lst(){
        //本月
        $user_id = input('user_id');
        if(isset($user_id)){


	        $stime=strtotime(date('Y-m', time()));
	        $etime=strtotime(date('Y-m',strtotime("+1months",time())));
	        $data=db('distribution_information')->where('distribution_user_id',$user_id)
	                                            ->where('distribution_time','>=',$stime)
	                                            ->where('distribution_time','<',$etime)
	                                            ->select();
	        $totalprict = 0;
	        $completed  = 0;
	        foreach ($data as $v) {
	        	 $totalprict += $v['distribution_totalprict'];
	        	 $completed  += $v['distribution_completed'];
	        	
	        }
	        //上5个月
	        $datas=array();
	        for ($i=0; $i <6 ; $i++) { 
	        	$etime=strtotime(date('Y-m',strtotime('-'.$i."months",time())));
	            $a=$i+1;
		        $stime=strtotime(date('Y-m',strtotime('-'.$a."months",time())));
		 
		        $data1=db('distribution_information')->where('distribution_user_id',$user_id)
		                                             ->where('distribution_time','>=',$stime) 
		                                             ->where('distribution_time','<',$etime)
		                                             ->select();
		       
		        $totalprict1 = 0;
		        $completed1  = 0;
		        foreach ($data1 as $v) {
		        	 $totalprict1 += $v['distribution_totalprict'];
		        	 $completed1  += $v['distribution_completed'];
		        	
		        }
                $unfinished1=number_format($totalprict1-$completed1,2);

		        $re1 =[
			       'month'=>date('m',strtotime('-'.$a."months",time())),
		           'totalprict'=>number_format($totalprict1,2),
		           'unfinished' =>$unfinished1,
		           'time_period'=>date('Y-m-1',strtotime('-'.$a."months",time())) .'—'. date('Y-m-1',strtotime('-'.$i."months",time()))
	            
	            ];
                
                
	        	array_push($datas,$re1);
	        	 
		        
	        }
            $unfinished=number_format($totalprict-$completed,2);
          
           
	        $re =[
	           'totalprict'=>number_format($totalprict,2),
	           'unfinished' =>$unfinished,
	           'time_period'=>date('Y-m-1', time()) .'—'. date('Y-m-1',strtotime("+1months",time()))
	            
	        ];

	    
	        return json_encode(array('status'=>'200','data'=>$re,'datas'=>$datas));
        }else{
        	return json_encode(array('status'=>'201','msg'=>"参数错误"));
        }
	}


	public function completed(){
        //已完成列表
        $user_id = input('user_id');
       if(isset($user_id)){
	        $datas=array();
	        $data=db('distribution_information')->paginate(10);

	        foreach ($data as $v) {
	            $id    = 	$v['distribution_id'];
	        	$totalprict=$v['distribution_totalprict'];

	        	$onedata=db('distribution_information')->order('distribution_time desc')
	        	                                       ->where('distribution_user_id',$user_id)
	        	                                       ->where('distribution_completed',$totalprict)
	                                                   ->where('distribution_id',$id)
	        	                                       ->find();
	        	if(isset($onedata)){
	        		array_push($datas,$onedata);
	        	}                                       	
	            

	        }     
	        return json_encode(array('status'=>'200','data'=>$datas));
	    }else{
	    	return json_encode(array('status'=>'201','msg'=>"参数错误"));
	    }

	}


	public function unfinished(){
        //未完成列表
        $user_id = input('user_id');
        if(isset($user_id)){
	        $datas=array();
	        $data=db('distribution_information')->paginate(10);
	        foreach ($data as $v) {
	            $id    = 	$v['distribution_id'];
	        	$totalprict=$v['distribution_totalprict'];
	        	$onedata=db('distribution_information')->order('distribution_time desc')
	        	                                       ->where('distribution_user_id',$user_id)
	        	                                       ->where('distribution_completed','<>',$totalprict)
	        	                                       ->where('distribution_id',$id)
	        	                                       ->find();	
	           if(isset($onedata)){
	        		array_push($datas,$onedata);
	        	} 


	        } 
	       
	        return json_encode(array('status'=>'200','data'=>$datas));
	    }else{
	    	return json_encode(array('status'=>'201','msg'=>"参数错误"));
	    }

	}
}