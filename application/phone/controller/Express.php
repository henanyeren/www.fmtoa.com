<?php
namespace  app\phone\controller;
use think\Collection;
class Express extends Collection{
    public function express(){

        //物流地区查询
        $list=db('app_express')->select();
        return json_encode(array('state'=>'200','msg'=>$list));
    }
}