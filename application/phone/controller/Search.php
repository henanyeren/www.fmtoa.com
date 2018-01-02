<?php
namespace app\phone\controller;
use   	  think\Controller;
//首页搜索
class Search extends Controller{ 
	public function lst(){
        	$kwd=input('kwd');     
                $data=model('AppCommodity')->where('commodity_name','like','%'.$kwd.'%')->select();
               // $data= $data;
                
                
              
                foreach ($data as $k=>$v) {
                	//$v['price']=db('AppCommodityPrice')->where('price_commodity_id',$v['commodity_id'])->find()['price'];
                	//$data[$k]['price']=$v['price'];
                	$data[$k]['time'] = date('Y-m-d',$v['time']);
                        $v->AppCommodityAdd;


                }
               
                if(!empty($data)){
                	
                	return json_encode(array('state'=>'200','data'=>$data));
                }else{
                	return json_encode(array('state'=>'200','msg'=>'no'));
                }
       
        
	}


	public function detail(){
		$commodity_id = input('commodity_id');

		$data= db('AppCommodity')->where('commodity_id',$commodity_id)->find();
		$data['time']= date('Y-m-d',$data['time']);
		return json_encode(array('state'=>'200','data'=>$data));
	}
}