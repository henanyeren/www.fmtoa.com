<?php
namespace app\admin\controller;
use think\controller;

class OrderManagement extends Common{
    public function lst(){
        $myname=db('admin')->field('admin_id,alias')->buildSql();
        $mydata=db('app_order')->alias('a')
            ->order('a.order_id desc')
            ->join([$myname=>'b'],'a.order_user_id = b.admin_id')
            ->join('app_order_add c','a.order_add_id = c.add_id')
            ->join('app_order_goods d','a.order_id = d.goods_order_id')
            ->select();
        $item=array();
        foreach($mydata as $k=>$v){
            if(!isset($item[$v['order_id']])){
                $item[$v['order_id']][]=$v;
            }else{
                $item[$v['order_id']][]=$v;
            }
        }
        $this->assign([
            'list'=>$item,
            'tabTitle'=>'订单列表',
        ]);

        $re=[
            'status'=>1,
            'page'=>$this->fetch('lst'),
        ];

        if(request()->isAjax()){
            return $re;
        }
    }

    public function detail(){
        $id=input('id');
        $myname=db('admin')->field('admin_id,alias')->buildSql();
        $detail=db('app_order')->where('order_id',$id)->find();
        if($detail){
            $mydata=db('app_order') ->where('order_id',$id)->alias('a')
                ->join([$myname=>'b'],'a.order_user_id = b.admin_id')
                ->join('app_order_add c','a.order_add_id = c.add_id')
                ->join('app_order_goods d','a.order_id = d.goods_order_id')
                ->select();
            $this->assign('detail',$mydata);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"订单详情");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

    public function examine(){
       $id= input('order_id');
        if(db('app_order')->where('order_id',$id)->update(['order_goods_state'=>1])){
            return array('state'=>1,'msg'=>'审核成功！');
        }else{
            return array('state'=>0,'msg'=>'审核失败');
        }
    }
    public function addlogistics(){
        $id=input('id');
        if(input('post.')){
        $id=input('order_id');
        $mydata=[
            'order_logistics'=>input('order_logistics'),
            'order_logistics_number'=>input('order_logistics_number'),
            'order_goods_state'=>2
        ];
            if(db('app_order')->where('order_id',$id)->update($mydata)){
                return array('state'=>1,'msg'=>'添加成功！');
            }else{
                return array('state'=>0,'msg'=>'添加失败');
            }
        }
        $express=db('app_express')->select();
        $this->assign([
            'order_id'=>$id,
            'express'=>$express,
        ]);
        $re=[
            'state'=>1,
            'page'=>$this->fetch('addlogistics'),
        ];
        return $re;
    }
}