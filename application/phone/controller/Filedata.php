<?php
	namespace app\phone\controller;
	use think\Controller;
	
	class Filedata extends Controller{
		public function  files(){
			
				if(!empty($_POST)){
					if(isset($_POST['pd'])){

					 $_POST['pd'] = str_replace('data:image/png;base64,', '', $_POST['pd']);
					
					$time=str_replace('-','',date('Y-m-d',time()));
					$img = 'uploads'.'/'.$time.'/'.uniqid().'.png';
					
					
					
					//file_put_contents($img, base64_decode($_POST['pd']));
					
					$res= array('status'=>'200','user_id'=>'123456');
					return json_encode($res);
					
					
					
				   }
				}
			
		}
		
		public function  login(){
	        $username=input('username');
			$password=input('password');
			session('user_id','12345');
			$re= array('status'=>'200','user_id'=>'123345');
			return json_encode($re);
	   }
	   
	   public function  doLogin(){
	        $username=input('username');
			$password=input('password');
			
			$re= array('status'=>'200','user_id'=>'123345');
			return json_encode($re);
	   }
	   
	    public function  down(){
	       
			
			$re= array('status'=>'200','user_id'=>'123345');
			return json_encode($re);
	   }
	   
	    public function  islogin(){
	       
			
			$re= array('status'=>'200','user_id'=>'123345');
			return json_encode($re);
	   }
	   
	   public function  diry(){
	       
			
			$re= array('status'=>'200','user_id'=>'123345');
			return json_encode($re);
	   }
	
			
	}
		
		
	