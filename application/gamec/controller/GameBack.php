<?php
namespace app\gamec\controller;

use think\Controller;
class GameBack extends Controller{
    public function _initialize()
    {
        //读取微信配置
        $options = config('wechat');
        $weObj= new \utild\Jssdk($options['appid'],$options['appSecret']);
        //微信分享
        $wechat= $weObj->GetSignPackage();
        $this->assign(array('signPackage' => $wechat));
}

    public function game(){
        //游戏开始也页面输出
        //获取id判断boss是存在  及血量是否为零   传递次数是否满了
        $id=input('id');
        //判断是否是分享游戏
        if($id){
        $myuid = db('ac_game_boss')->where('id', $id)->find();
        //判断循环结束否？
        if(!$myuid || $myuid['hp']==0  || $myuid['uid']==3){
          //返回新页面
            echo 2;
            return view('game2');
        }else{
            echo 1;
            //返回接力页面
            $this->assign('id',$id);
            return view('game1');
        }}else{
            echo 3;
            //返回全新页面
            return view('game2');
        }
    }


    //接力信息提交页面
    public function game1(){
        $id=[
            'pid'=>input('id'),
            'name'=>input('name'),
            'phone'=>input('phone'),
        ];
        $myuid = db('ac_game_boss')->where('id', $id['pid'])->find();
        $where = [
            'id' => $id['pid'],
            'uid' => $myuid['uid'] + 1,
        ];
        db('ac_game_boss')->update($where);
        db('ac_game_name')->insert($id);

        $this->redirect('http://www.fmtoa.com/game_back/index.html?id='.$id['pid']);
    }
    //全新游戏页面 并创建boss
    public function game2(){
        $myboss=[
            'hp'=>200,
            'uid'=>1,
        ];
        $id=db('ac_game_boss')->insertGetId($myboss);
        $data = [
            'name' => input('name'),
            'phone' => input('phone'),
            'pid' =>$id,
        ];
        db('ac_game_name')->insert($data);
        $this->redirect('http://www.fmtoa.com/game_back/index.html?id='.$id);
    }

    //获取boss血量  生成信息链接   打败boss或者失败时的跳转链接
    public function boss(){
        //获取bossid
        $id=input('id');
        if($id){
            //查出boss血量并返回
            $myuid = db('ac_game_boss')->where('id', $id)->find();
            //游戏结束跳转地址 及参数
            $myuid['url']="http://www.fmtoa.com/game_back/game_back/over?id=".$id;
           return  json_encode($myuid);
        }else{
            //返回全新页面
            return view();
        }
    }


    //游戏结束信息采集页面
    public function over(){
            $data=[
                    'id'=>input('id'),
                    'hp'=>input('hp'),
                ];
           // dump($data);
            if($data['hp']!=0){
                db('ac_game_boss')->update($data);
                return view('error');
            }else{
                db('ac_game_boss')->update($data);
                return view('success');
            }
        }
}