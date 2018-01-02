<?php
namespace app\phone\controller;

use think\Controller;
class Address extends Controller{
    public function addhanddle(){
        //添加收货地址
        $data=[
            'add_tel'=>input('tel'),//联系电话
            'add_name'=>input('name'),//联系姓名
            'add_content'=>input('content'),//详细地址
            'add_user_id'=>input('user_id'),//用户id
        ];

        if(isset($data['add_user_id'])){
            if(db('admin')->where('admin_id',$data['add_user_id'])->find()){

                if(db('app_order_add')->insert($data)){
                    if(input('add_id')){
                        $data=[
                            'add_state'=>1
                        ];
                        db('app_order_add')->where('add_id',input('add_id'))->update($data);
                    }
                    return json_encode(array('state'=>'200','msg'=>'地址添加成功.'));
                }else{
                    return json_encode(array('state'=>'101','msg'=>'地址添加失败!!!'));
                }
            }else{
                return json_encode(array('state'=>'101','msg'=>'查询错误!'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误！！'));
        }
    }

    public function lst(){
        //获取收货地址
        $id=input('user_id');//用户id
        if(isset($id)){
            $where=[
                'add_user_id'=>$id,
                'add_state'=>0
            ];
            $data=db('app_order_add')->order('add_id desc')->where($where)->select();
            if(db('admin')->where('admin_id',$id)->find()){
                return json_encode(array('state'=>'200','data'=>$data));
            }else {
                return json_encode(array('state' => '101', 'msg' => '查询失败！！'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误！！'));
        }
    }

    public function del(){
        //删除收货地址
        $id=input('add_id');
        if(isset($id)){
            $data=[
                'add_state'=>1
            ];
            if(db('app_order_add')->where('add_id',$id)->update($data)){
                return json_encode(array('state'=>'200','msg'=>'删除成功'));
            }else{
                return json_encode(array('state'=>'101','msg'=>'删除失败！！'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误！！'));
        }
    }

    public function upd(){
        //获取用户要修改的地址
        $id=input('add_id');
        if(isset($id)){
            $data=[
                'add_state'=>0,
                'add_id'=>$id,
            ];
            $mydata=db('app_order_add')->where($data)->select();
            if($mydata) {
                return json_encode(array('state'=>'200','data'=>$mydata));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数不存在！！'));
        }

    }

    public function updone(){
        //获取用户最新收货地址
        $id=input('user_id');
        if($id){
            $data=[
                'add_state'=>0,
                'user_id'=>$id,
            ];
            $mydata=db('app_order_add')->order('add_id desc')->where($data)->limit(0,1)->select();
            if($mydata) {
                return json_encode(array('state'=>'200','data'=>$mydata));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数不存在！！'));
        }

    }

}