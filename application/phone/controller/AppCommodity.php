<?php
	namespace app\phone\controller;
	use think\Controller;

	class AppCommodity extends Controller{

		
	public function lst()
	{
		
			$listInfo=db('AppCommodity')->select();
			if($listInfo){
				return json_encode($listInfo);
			}
			return json_encode(array('status'=>100,'msg'=>'未找到产品信息'));
			 
		
		}

	}
