<?php
namespace app\phone\controller;

use think\Controller;

class Activity extends Controller{
	
	public function lst(){
		$data = db('Activity')->order('time desc')->paginate(8);
		$data =$data->toArray();
		foreach ($data['data'] as $k => $v) {
			$data['data'][$k]['time'] = date('Y-m-d', $v['time']);
		}
		
		return json_encode(array('state'=>'200','data'=>$data));
	}

	public function showLst(){
		$id = input('id');
		$vodata = db('ActivityVideoPicture')->where('pid',$id)->where('type','1')->paginate(10);
        $imgdata = db('ActivityVideoPicture')->where('pid',$id)->order('time desc')->where('type','0')->limit(6)->select();
        $vodata->toArray();
		return json_encode(array('state'=>'200','vodata'=>$vodata,'imgdata'=>$imgdata));
	}

	public function showimg(){
		$id = input('id');
        $imgdata = db('ActivityVideoPicture')->where('pid',$id)->order('time desc')->where('type','0')->select();
       
		return json_encode(array('state'=>'200','imgdata'=>$imgdata));
	}
}