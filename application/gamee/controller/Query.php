<?php
namespace  app\gamee\controller;
use think\Controller;
class Query extends Controller{
    //商家查询页面
    public function query(){
        if(request()->isPost()) {
           $mydata=input('name');
           $myname=db('ae_game_name')->whereOr('name',$mydata)->whereOr('phone',$mydata)->find();
           if($myname){
                if($myname['record']!=0){
                    $data="<p>你已经于".date('Y-M-D',$mydata['time'])."领取过奖励了</p>";
                }else{
                    if($myname['pid']!=0) {
                        $myboss = db('ae_game_boss')->where('id', $myname['pid'])->find();
                    }
                    if($myname['pid']!=0 && $myboss) {
                        if($myboss['hp']!=0){
                            $data="<p>boss还未死亡</p>";
                        }else{
                            $data="<p style='color: #0A9800;font-size: 24px;'>可以领取奖励</p>";
                        }
                    }else{
                        $data="<p>你还未参与比赛</p>";
                    }
                }
           }else{
               $data="<p>未查询到参赛记录</p>";

           }
            $this->assign('data',$data);
            return view('myreward');
        }else{
            return view('query');
        }

    }
    public function no(){
        echo  "<p style='margin: 200px 33%;font-size: 48px;'><span style='color: red;'>请在微信端打开</span></p>";
    }
}