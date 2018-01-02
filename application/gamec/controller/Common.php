<?php
namespace app\gamec\controller;

use think\Controller;
class Common extends Controller{
    public function _initialize()
    {  //读取微信配置
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            //是微信浏览器
            $a=0;
        }else{
            //不是微信浏览器
            $this->redirect("http://www.fmtoa.com/game/query/no");
        }
        $options = config('wechat');
        $weObj= new \utild\Jssdk($options['appid'],$options['appSecret']);
        //微信分享
        $wechat= $weObj->GetSignPackage();
        $this->assign(array('signPackage' => $wechat));

    }

}