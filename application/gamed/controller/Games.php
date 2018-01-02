<?php
namespace app\gamed\controller;

use think\Controller;
class Game extends Controller{
    public function _initialize()
    {  //读取微信配置
        $options = config('wechat');
        $weObj= new \utild\Jssdk($options['appid'],$options['appSecret']);
        //微信分享
        $wechat= $weObj->GetSignPackage();
        $this->assign(array('signPackage' => $wechat));
}

    public function game(){
        //游戏开始也页面输出
        $id=input('id');
        //判断是否是分享游戏
        if($id){
        $myuid = db('ad_game_boss')->where('id', $id)->find();
        //判断循环结束否？
        if(!$myuid || $myuid['hp']==0){
          //返回新页面
            cookie('hp',0);
            cookie('pid',$myuid['pid']);
            return view('game2');
        }else{

            //返回接力页面
            $this->assign('id',$id);
            return view('game1');
        }}else{

            //返回全新页面
            return view('game2');
        }
    }


    //接力信息提交页面
    public function game1(){
        $id=[
            'pid'=>0,
            'name'=>input('name'),
            'phone'=>input('phone'),
        ];
            $myuid = db('ad_game_boss')->where('id', $id['pid'])->find();
            $where = [
                'id' => $id['pid'],
                'uid' => $myuid['uid'] + 1,
            ];
            db('ad_game_boss')->update($where);

            //判断信息是否填充过，有就不继续填充
            $mydata= db('ad_game_name')->where('phone',input('phone'))->select();
            if($mydata) {
                cookie('name', input('name'));
                cookie('new', 1);
            }else{
            db('ad_game_name')->insert($id);
            cookie('name', input('name'));
            cookie('new',1);
        }

            $this->redirect('http://www.fmtoa.com/game/index.html?id=' . input('id'));
    }
    //全新游戏页面 并创建boss
    public function game2(){
        $data = [
            'name' => input('name'),
            'phone' => input('phone'),
        ];
        $mydata=db('ad_game_name')->where(['phone'=>$data['phone'],'pid'=>cookie('pid')])->find();
        if(cookie('hp')==0 && $mydata){
            return view('success');
        }else {
            $myboss = [
                'hp' => 200,
                'uid' => 1,
            ];
            $id = db('ad_game_boss')->insertGetId($myboss);
            $data['pid'] = $id;

            //记录姓名和是否是新游戏
                $pid=db('ad_game_name')->insert($data);
                cookie('name', input('name'));
                cookie('new',0);

                $this->redirect('http://www.fmtoa.com/game/index.html?id=' . $id);

        }
    }

    //获取boss血量  生成信息链接   打败boss或者失败时的跳转链接
    public function boss(){
        //获取bossid
        $id=input('id');
        if($id){
            //查出boss血量并返回
            $myuid = db('ad_game_boss')->where('id', $id)->find();
            //游戏结束跳转地址 及参数
            $myuid['url']="http://www.fmtoa.com/game/game/over?id=".$id;
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
                db('ad_game_boss')->update($data);
                $this->assign([
                    'id'=>$data['id'],
                    'name'=>cookie('name'),
                    ]);
                return view('error');
            }else{
                if(cookie('new')==1){
                    db('ad_game_boss')->update($data);
                }else{
                    db('ad_game_boss')->update($data);
                    return view('success');
                }
            }
        }


        public function reward(){
            return view();
        }



}