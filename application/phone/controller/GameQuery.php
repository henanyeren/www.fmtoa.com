<?php
namespace  app\phone\controller;
use think\Controller;
class GameQuery extends Controller{
    //商家查询页面
    public function query(){

            $mydata = input('name');
            $myname = db('a_game_name')->whereOr('name','like','%'.$mydata.'%')->whereOr('phone','like','%'.$mydata.'%')
                ->alias('a')
                ->join('a_game_boss b','a.pid = b.id')
                ->select();
            if(!$myname){
                return json_encode(array('state'=>201,'data'=>$myname));
            }
            return json_encode(array('state'=>200,'data'=>$myname));
        }

        public function gets(){
            $myid=input('id');
            if($myid){
                $my=db('a_game_name')->where('id',$myid)
                    ->find();
                if($my && $my['pid']==0){
                    return json_encode(array('state'=>101,'data'=>"未参加活动！"));
                }
                $myboss=db('a_game_boss')->where('id',$my['pid'])->find();
                if($myboss && $myboss['hp']==0){
                        if($my['record']==0){
                            $my=db('a_game_name')->where('id',$myid)->update(array('id'=>$myid,'record'=>1,'time'=>date('Y-m-d H:i:s',time())));
                            if($my) {
                                return json_encode(array('state' => '200', 'data' => "领取成功！！"));
                            }
                        }else{
                            return json_encode(array('state'=>'101','data'=>"已经领取,请勿重复操作！"));
                        }
                }else{
                    return json_encode(array('state'=>'201','data'=>"不符合领取资格"));
                }

            }
            return json_encode(array('state'=>'101','data'=>"错误操作！"));

        }
        public function remark(){
            $myid=input('id');
            $myre=input('remark');
            if(!$myid){
                return json_encode(array('state'=>'101','data'=>"修改失败"));
            }
            $myremark=db('a_game_name')->update(array('id'=>$myid,'remark'=>$myre));
            if($myremark){
                return json_encode(array('state'=>'200','data'=>"修改成功"));
            }else{
                return json_encode(array('state'=>'101','data'=>"修改失败"));
            }
        }

}