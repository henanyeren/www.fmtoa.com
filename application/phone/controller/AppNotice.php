<?php
	namespace app\phone\controller;
	use think\Controller;

	class AppNotice extends Controller{
		
	public function detail()
	{
		$id=input('app_id');
		$detail=db('AppNotice')->find($id);
		if($detail){

		    $detail['app_time']=date('Y年m月d日',$detail['app_time']);
			return json_encode($detail);
		}else{
			return json_encode(array('找不到你要的公告'));
		}
			
	}

	public function show()
	{
		//详情页面返回到view页面
		$id=input('app_id');
		$detail=db('AppNotice')->find($id);
		if($detail){

		    $detail['app_time']=date('Y年m月d日',$detail['app_time']);
		    
			$this->assign('detail',$detail);	
			return $this->fetch();
		}
			
	}

	public function video(){
		//详情页面返回到view页面
		$id=input('app_id');
		$detail=db('video')->find($id);
		if($detail){
            //$list=$listInfo->toArray(); 
		    //$detail['app_time']=date('Y年m月d日',$detail['app_time']);
		    
			$this->assign('detail',$detail);	
			return $this->fetch();
		}

	
			
	}
	
		
	public function lst()
	{   //获取公告
			$data = array();
            $where=[
            'app_notice_state'=>1,
            ];

			$listInfo=db('AppNotice')->order('app_id desc')->where($where)->paginate(10);
			$list=$listInfo->toArray();
			
			foreach($list['data'] as $k=>$v){
				$v['app_time']=date('m-d',$v['app_time']);
				array_push($data,$v);
			}			
			
			$list['data']=$data;
			$re=json_encode($list);
			return $re;
		
	}
		public function is_hot()
        {
            //首页新闻列表  默认最新五条
          $data=array();
            $where=[ ];
            $listInfo = db('AppNotice')->order('app_id desc')->where($where)->paginate(5);
            $list = $listInfo->toArray();

            foreach ($list['data'] as $k => $v) {
                $v['app_time'] = date('m-d', $v['app_time']);
                array_push($data, $v);
            }

            $list['data'] = $data;
            $re = json_encode($list);
            return $re;
        }


        public function intelligencelst()
        {   //详细新闻列表
            $data = array();
            $id=input('notice_type');
            $where=[
                'app_notice_type'=>$id,
            ];

            $listInfo=db('AppNotice')->order('app_id desc')->where($where)->paginate(10);
            $list=$listInfo->toArray();

            foreach($list['data'] as $k=>$v){
                $v['app_time']=date('m-d',$v['app_time']);
                array_push($data,$v);
            }

            $list['data']=$data;
            $re=json_encode($list);
            return $re;

        }
		
	}
