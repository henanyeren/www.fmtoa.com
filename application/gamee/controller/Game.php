<?php
namespace app\gamee\controller;

use think\Controller;
class Game extends Common {
    public function game(){
        //游戏开始也页面输出
        $id=input('id');
        //判断是否是分享游戏
        if($id) {
            $myuid = db('ae_game_boss')->where('id', $id)->find();
            if($myuid && $myuid['hp']!=0){
                cookie('hp', $myuid['hp']);
                cookie('pid', $myuid['pid']);
                cookie('uid', $myuid['uid']);
                cookie('id',$myuid['id']);
                cookie('new',0);
                return view();
            }else{
                cookie('new',1);
                //提示页面
                $this->assign([
                    'title'=>'分享游戏已完成！你可以重新开始游戏赢取大奖！！或者查询游戏战果',
                    'hp'=>0,
                    'uid'=>0,
                ]);
                return view('prompt');
            }
        }else{
            //新游戏页面
            cookie('new',1);
            return view();
        }
    }
    public function games(){
        if(input('name')=="" && input('phone')==""){
            $this->redirect(url('game'));
        }else{
        $myname=[
            'name'=>input('name'),
            'phone'=>input('phone'),
        ];
        cookie('name',input('name'));
        cookie('phone',input('phone'));
        $data=db('ae_game_name')->where($myname)->find();
        if(cookie('new')==1) {
            if($data && $data['pid']!=0){
                $myboss=db('ae_game_boss')->where('id',$data['pid'])->find();
                $this->assign([
                    'title'=>'你已经发起游戏！坐等好友助力得大奖！！你可以点击查询游戏战果',
                    'hp'=>$myboss['hp'],
                    'uid'=>$myboss['uid']
                ]);
                return view('prompt');
            }
            $myboss = [
                'hp' => 200,
                'uid' => 1,
            ];
            $id = db('ae_game_boss')->insertGetId($myboss);
            if($data){
                db('ae_game_name')->update(['id'=>$data['id'],'pid'=>$id]);
                db('ae_game_boss')->update(['id'=>$id,'pid'=>$data['id']]);
            }else{
                $myname['pid']=$id;
                $myname['add_time']=time();
                $pid=db('ae_game_name')->insertGetId($myname);
                db('ae_game_boss')->update(['id'=>$id,'pid'=>$pid]);
            }
            cookie('id',$id);
            return view('mygame');
        }else{
            $myuid = db('ae_game_boss')->where('id', cookie('id'))->find();
            $where = [
                'id' => cookie('id'),
                'uid' => $myuid['uid'] + 1,
            ];
            if($data){
                db('ae_game_boss')->update($where);
                return view('mygame');
            }else{
                $id=[
                    'pid'=>0,
                    'name'=>input('name'),
                    'phone'=>input('phone'),
                ];
                $id['add_time']=time();
                db('ae_game_name')->insert($id);
                return view('mygame');
            }
        }
        }
    }

    public function mygame(){
            $this->redirect('http://www.fmtoa.com/mygame/gamee/index.html?id='.cookie('id'));
    }


    //获取boss血量  生成信息链接   打败boss或者失败时的跳转链接
    public function boss(){
        //获取bossid
        $id=input('id');
        if($id){
            //查出boss血量并返回
            $myuid = db('ae_game_boss')->where('id',$id)->find();
            //游戏结束跳转地址 及参数
            $myuid['url']="http://www.fmtoa.com/gamee/game/over?id=".$id;
           return  json_encode($myuid);
        }else{
            //返回全新页面
           echo "信息错误！！！";
        }
    }

    //游戏结束信息采集页面
    public function over(){
            $data=[
                    'id'=>input('id'),
                    'hp'=>input('hp'),
                ];
            if($data['hp']!=0){
                db('ae_game_boss')->update($data);

                $this->assign([
                    'id'=>$data['id'],
                    'name'=>cookie('name'),
                    ]);
                if(cookie('new')==1) {
                    $this->assign('data',"分享给好友,一起闯关领奖励！");
                    return view('error');
                }else{
                    $this->assign('data',"赶快分享好友，帮你的朋友拿去奖励吧!");
                    return view('error');
                }
            }else{
                    db('ae_game_boss')->update($data);
                if(cookie('new')==1) {
                    return view('success');
                }else{
                    $this->assign([
                        'title'=>'恭喜你！帮好友获取狗年纪念币一枚！ 你可以从新开始游戏获取！',
                        'hp'=>0,
                        'uid'=>0,
                    ]);
                    return view('prompt');
                }
            }
        }

//查询页面
        public function query(){
        if(request()->isPost()){
            $myname=[
                'name'=>input('name'),
                'phone'=>input('phone'),
            ];

            $data=db('ae_game_name')->where($myname)->find();
            if($data && $data['pid']!=0){
                $myboss=db('ae_game_boss')->where('id',$data['pid'])->find();
                if($myboss['hp']==0){
                    cookie('id',0);
                    return view('success');
                }else{
                    cookie('id',$myboss['id']);
                    $this->assign([
                        'name'=>input('name'),
                       'id'=>$myboss['id'],
                       'myname'=>$data,
                        'data'=>$myboss
                    ]);
                    return view('myreward');
                }
            }else{
                cookie('new',1);
                //提示页面
                $this->assign([
                    'title'=>'<span style="color: #002DFF;font-size: 18px;">未查到数据！你可以重新开始游戏赢取大奖！！或者再次查询游戏战果</span>',
                    'hp'=>0,
                    'uid'=>0,
                ]);
                return view('prompt');
            }
        }
        if(cookie('name')&&cookie('phone')){
            $myname=[
                'name'=>cookie('name'),
                'phone'=>cookie('phone'),
            ];
            $data=db('ae_game_name')->where($myname)->find();
            if($data && $data['pid']!=0){
                $myboss=db('ae_game_boss')->where('id',$data['pid'])->find();
                if($myboss['hp']==0){
                    cookie('id',0);
                    return view('success');
                }else{
                    cookie('id',$myboss['id']);
                    $this->assign([
                        'name'=>input('name'),
                        'id'=>$myboss['id'],
                        'myname'=>$data,
                        'data'=>$myboss
                    ]);
                    return view('myreward');
                }
            }else{
                cookie('new',1);
                //提示页面
                $this->assign([
                    'title'=>'未查到数据！你可以重新开始游戏赢取大奖！！或者再次查询游戏战果',
                    'hp'=>0,
                    'uid'=>0,
                ]);
                return view('prompt');
            }
        }
            return view();
        }
        //领取奖励
     public function reward(){
        return view();
        }
        //奖励详情
        public function details(){
        return view();
         }




}