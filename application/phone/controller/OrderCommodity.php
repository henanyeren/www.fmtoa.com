<?php
namespace app\phone\controller;

use think\Controller;
class OrderCommodity extends Controller{
   public function goodslst(){
       $price_add_id=input('price_add_id');//获取地址id   1,2
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

    public function orderhanddle(){
            //获取用户基本信息
            $data['order_user_id']=input('user_id');//获取用户id
            $data['order_add_id']=input('add_id');//获取收货地址id
            $data['order_price']=input('order_price');//获取总价
            $data['order_content']=input('content');//备注
            $data['order_payment_method']=input('payment_method');
            $data['order_time']=time();

            $data['order_goods_state']=-1;

        //获取购买商品基本信息
        $goods_id=input('goods_id');//商品id
        $goods_num=input('goods_num');//商品数量
        $price_add_id=input('price_add_id');//商品地区id

        $goodsid=explode(',',$goods_id);
        $goodsnum=explode(',',$goods_num);

        //计算商品种类和商品数量的个数 是否相同
        $number1=count($goodsid);
        $number2=count($goodsnum);

        if($number1 === $number2){

            if(db('admin')->where('admin_id',$data['order_user_id'])->select()){

                db('app_order')->insert($data);
                $id=db('app_order')->getLastInsID();


                if($id){
                    for($i=0;$i<$number2;++$i){
                        $where=[
                            'price_add_id'=>$price_add_id,
                           'price_commodity_id'=>$goodsid[$i],
                        ];
                        $money=db('app_commodity_price')->where($where)->find();
                        $good=db('app_commodity')->where('commodity_id',$goodsid[$i])->field('commodity_preview,commodity_name')->select();


                        $goods['goods_img']=$good[0]['commodity_preview'];
                        $goods['goods_name']=$good[0]['commodity_name'];
                        $goods['goods_number']=$goodsnum[$i];
                        $goods['goods_order_id']=$id;
                        $goods['goods_price']= $money['price'];
                        db('app_order_goods')->insert($goods);
                    }
                if (count(db('app_order_goods')->where('goods_order_id',$id)->select())== $number2){
                    if(strlen($id)<5){
                        $nm=5-strlen($id);
                        $mydata['ID']=str_pad($id,5,0,STR_PAD_LEFT);
                    }else{
                        $mydata['ID']=$id;
                    }
                        $state['order_goods_state']=0;
                        $state['order_number']=$mydata['ID'];
                   if(db('app_order')->where('order_id',$id)->update($state)){

                       $mydata['order_price']= $data['order_price'];
                       return json_encode(array('state'=>'200','msg'=>'订单提交成功','data'=>$mydata));
                   }

                }else{
                    return json_encode(array('state'=>'101','msg'=>'订单详情提交失败'));
                }

                }else{
                    return json_encode(array('state'=>'101','msg'=>'订单提交失败'));
                }
            }else{
                return json_encode(array('state'=>'101','msg'=>'请输入正确的id'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'商品错误'));
        }
    }

    public  function orderlst(){
        //查询用户所有订单
        $user_id=input('user_id');//获取用户id
        if(isset($user_id)){
            $where=[
                'order_user_id'=>$user_id,
                'order_goods_state'=>['>=',0],
            ];
            $mydata=db('app_order')->order('order_id desc')->where($where)->paginate(4);
            $data=$mydata->toArray();
            if($data['total']!=0){
                $timedata=array();
                foreach ($data['data'] as $k=>$v){
                    $v['order_time']=date('Y-m-d H:i:s',$v['order_time']);
                    array_push($timedata,$v);
                }
                $data['data']=$timedata;
                return json_encode(array('state'=>'200','data'=>$data));
            }else{
                return json_encode(array('state'=>'204','msg'=>'当前用户还没有订单'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'用户名有误'));
        }
    }

    public function orderway(){
        //查询未完成订单
        $user_id=input('user_id');//获取用户id
        if(isset($user_id)){
            $where=[
                'order_user_id'=>$user_id,
            ];
            $mydata=db('app_order')->order('order_id desc')->where('order_goods_state','in','0,1,2')->where($where)->paginate(4);
            $data=$mydata->toArray();
            if($data['total']!=0){
                $timedata=array();
                foreach ($data['data'] as $k=>$v){
                    $v['order_time']=date('Y-m-d H:i:s',$v['order_time']);
                    array_push($timedata,$v);
                }
                $data['data']=$timedata;
                return json_encode(array('state'=>'200','data'=>$data));
            }else{
                return json_encode(array('state'=>'204','msg'=>'当前用户还没有订单'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'用户名有误'));
        }
    }

    public function ordercomplete(){
        //查询已完成订单
        $user_id=input('user_id');//获取用户id
        if(isset($user_id)){
            $where=[
                'order_user_id'=>$user_id,
                'order_goods_state'=>3,
            ];
            $mydata=db('app_order')->order('order_id desc')->where($where)->paginate(4);
            $data=$mydata->toArray();
            if($data['total']!=0){
                $timedata=array();
                foreach ($data['data'] as $k=>$v){
                    $v['order_time']=date('Y-m-d H:i:s',$v['order_time']);
                    array_push($timedata,$v);
                }
                $data['data']=$timedata;
                return json_encode(array('state'=>'200','data'=>$data));
            }else{
                return json_encode(array('state'=>'204','msg'=>'当前用户还没有订单'));
            }
        }else{
         return json_encode(array('state'=>'101','msg'=>'用户名有误'));

    }
        }

    public function orderone(){
        //查询用户订单详细信息
        //订单号
        $id=input('order_id');
        if(isset($id)){
            $list=db('app_order')->alias('a')->
            join('app_order_add b','a.order_add_id = b.add_id')->where('a.order_id',$id)->find();
            if ($list) {

                  $goods  = db('app_order_goods')->where('goods_order_id', $id)->select();
                $list['goods'] =$goods;
                //var_dump($list['goods']);
                $list['state'] = '200';
                $list['order_time'] = date('Y-m-d H:i:s', $list['order_time']);
                return json_encode($list);
            }else{
                return json_encode(array('state'=>'101','msg'=>'此账单被外星人带走了:('));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'订单号不正确'));
        }
    }
}