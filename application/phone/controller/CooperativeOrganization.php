<?php
	namespace app\phone\controller;
	use think\Controller;

	class CooperativeOrganization extends Controller{
		
		//获取合作机构的列表
		public function lst(){
			$data = array();
			$listInfo=db('cooperative_organization')->order('co_id desc')->paginate(10);
			$list=$listInfo->toArray();
			
			foreach($list['data'] as $k=>$v){
				array_push($data,$v);
			}
			$list['data']=$data;
			$re=json_encode($list);
			return $re;			
        }
        public function detail(){
        //获取合作机构详细信息
        $id=input('co_id');
        if (isset($id)) {
            $data = db('cooperative_organization')->where('co_id', $id)->find();
            $data['co_time']=date('Y-m-d H:i:s',$data['co_time']);
            return json_encode($data);
        }else{
            return json_encode(array('state'=>'101','msg'=>'获取失败'));
        }
        }

    }
 