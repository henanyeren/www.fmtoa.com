<?php
namespace app\phone\controller;
use think\Controller;

class Order extends Controller{
	public function index(){
		
		return $this->fetch();
	}

	public function index_lst(){

	   $price_add_id= 1 ;//获取地址id   1,2
       if(isset($price_add_id)){
       $money=db('app_commodity_price')->where('price_add_id',$price_add_id)->buildSql();
       if($money){
           $list=db('app_commodity')->alias('a')->
           join([$money=>'b'],'a.commodity_id = b.price_commodity_id')->select();
           if($list){
               return json_encode(array('state'=>'200','data'=>$list));
           }else{
               return json_encode(array('state'=>'101','msg'=>'查询错误'));
           }
       }else{
           return json_encode(array('state'=>'101','msg'=>'地址ip错误'));
       }}else{
           return json_encode(array('state'=>'101','msg'=>'请输入id'));
       }
	}

	public function show(){
		return $this->fetch();
	}
}