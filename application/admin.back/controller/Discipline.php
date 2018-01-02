<?php
namespace app\admin\controller;

class Discipline extends Common{
    public function lst()
    {
        $id = input('product_test_type');
        if (!$id){
            $mylist = db('app_discipline')->order('discipline_id desc')->select();
            $this->assign([
                'list'=>$mylist,
                'tabTitle'=>'入库检列表'
            ]);
            $re=[
                'status'=>1,
                'page'=>$this->fetch(),
            ];
            if(request()->isAjax()){
                return $re;
            }
    }else{
            $mylist = db('app_product_test')->order('product_test_id desc')->where('product_test_type',$id)->select();

            $this->assign([
                'list'=>$mylist,
                'tabTitle'=>'入库检列表'
            ]);
            $re=[
                'status'=>1,
                'page'=>$this->fetch('lsts'),
            ];
            if(request()->isAjax()){
                return $re;
            }
        }

    }
    public function detail_print(){
        $id=input('id');
        $mytop=db('app_discipline')->where('discipline_id',$id)->find();
        $mylist=db('app_discipline_goods')->where('discipline_pid',$id)->select();
        if($mytop && $mylist){
            $this->assign([
                'mylist'=>$mytop,
                'list'=>$mylist,
            ]);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

    public function detail(){
        $id=input('id');
        $mytop=db('app_discipline')->where('discipline_id',$id)->find();
        $mylist=db('app_discipline_goods')->where('discipline_pid',$id)->select();
        $list=array();
        foreach($mylist as $value){
            $value['discipline_goods_img']=explode(',',$value['discipline_goods_img']);
            $list[]=$value;
        }
        if($mytop && $list){
            $this->assign([
                'mylist'=>$mytop,
                'list'=>$list,
            ]);
            return array('state'=>'1','msg'=>$this->fetch('detail'),'name'=>"");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }
        public function details(){
            $id=input('id');
            $mydata=db('app_product_test')->where('product_test_id',$id)->find();

            if($mydata){
                $this->assign([
                    'detail'=>$mydata,
                ]);
                return array('state'=>'1','msg'=>$this->fetch(),'name'=>"质检详情");
            }else{
                return array('state'=>'0','msg'=>'查询错误');
            }
            }

    public function manager()
    {

        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        return $re;
    }
}