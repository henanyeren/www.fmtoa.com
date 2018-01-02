<?php
namespace app\phone\controller;
use think\Controller;
use word\nclass\word;
class App extends Controller
{
    public function app(){
        $myapp=db('app_history')->order('app_id desc')->find();
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            //是微信浏览器
            $a=0;
        }else{
            //不是微信浏览器
        $a=1;
        }
        $this->assign([
            'myapp'=>$myapp,
            'a'=>$a,
            ]);
        return $this->fetch('app_download');
    }
    public function app_log(){
        $myapp=db('app_history')->order('app_id desc')->select();
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            //是微信浏览器
            $a=0;
        }else{
            //不是微信浏览器
            $a=1;
        }
        $this->assign([
            'myapp'=>$myapp,
            'a'=>$a,
        ]);
        return $this->fetch();
    }
    public function words(){
        $html = ' 
            <h1>你好啊</h1> 
            <h2>欢迎光临<a href="http://www.dawnfly.cn">破晓博客</a></h2>
            <img width="300px" src="http://www.dawnfly.cn/Source/home/top_ad.jpg" alt="">
            ';

        $word = new word();
        $word->start();
        $wordname = "欢迎光顾破晓博客网站，技术交流与学习的平台.doc";
        $wordname = iconv('UTF-8','GBK',   $wordname);//防止乱码
        $html=iconv('UTF-8','GBK',  $html); //防止乱码
        echo $html;
        $word->save('C:/Users/Administrator/Desktop/'.$wordname); //可以自定义保存路径
        ob_flush();//每次执行前刷新缓存
        flush();


    }
}