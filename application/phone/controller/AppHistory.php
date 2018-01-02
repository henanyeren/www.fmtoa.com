<?php
namespace app\app\controller;
use think\Controller;
class AppHistory extends Controller
{
    public function app(){

        if(request()->post()){
            $file = request()->file('app_file');
            $appdata['app_time']=time();
            $files="public/file/{$appdata['app_time']}";
            $fileadd="/file/{$appdata['app_time']}";
            $info = $file->validate(['size'=>50056050,'ext'=>'apk'])->move(ROOT_PATH .$files,'');
            if($info){
            $appdata['app_file']=" $fileadd" .'/' . $info->getSaveName();
            $appdata['app_number']=input('app_number');
            $appdata['app_remark']=input('app_remark');
            $appdata['app_log']=input('app_log');
            $res= db('app_history')->insert($appdata);
            if($res){
                $this->success('app添加成功','http://www.baidu.com');
            }else{
                $this->error('app添加失败');
            }
        }else{
            $this->error('文件有误');
        }}

     return   $this->fetch('app_history');
    }
    public function history(){
        if (request()->isAjax()){
                $validate=\think\Loader::validate('history');
                $mypost=request()->post();
                $mykey=array_keys($mypost)[0];
                if (!$validate->scene($mykey)->check($mypost)){
                    return array('state'=>'0','msg'=>$validate->getError());
                }else{
                    return array('state'=>'1','msg'=>'可以使用');
                }
            }

    }

}