<?php
namespace app\admin\controller;
use think\Controller;
class AppHistory extends Controller
{
    public function app(){

        if(request()->post()) {

            $appdata['app_time'] = time();
            $appdata['app_file'] = input('app_file');
            $appdata['app_number'] = input('app_number');
            $appdata['app_remark'] = input('app_remark');
            $appdata['app_log'] = input('app_log');
            $res = db('app_history')->insert($appdata);
            if ($res) {
                return array('state'=>1,'msg'=>'添加成功！');
            } else {
                return array('state'=>1,'msg'=>'添加失败');
            }
        }

        $re=[
            'status'=>1,
            'page'=>$this->fetch('app'),
        ];
        return $re;

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

    public function lst(){
     $myapp=db('app_history')->order('app_id desc')->select();
        $this->assign('myapp',$myapp);
        $re=[
            'status'=>1,
            'page'=>$this->fetch('lst'),
        ];

        if(request()->isAjax()){
            return $re;
        }
    }
    public function del()
    {
        $id = input('app_id');
        $myapp = db('app_history')->delete($id);
        if ($myapp) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下

        $appdata['app_time']=time();
        $files="public".DS."appfile".DS.$appdata['app_time'];
        $fileadd=DS."appfile".DS.$appdata['app_time'];
        $info = $file->move(ROOT_PATH .$files,'');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            $address=$fileadd.DS.$info->getSaveName();
            return $address;
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }


    //修改获取页面
    public function upd()
    {
        $id=input('id');
        $detail_info=db('app_history')->find($id);
        $this->assign('app',$detail_info);

        $re=[
            'status'=>1,
            'page'=>$this->fetch('upd'),
        ];

        return $re;
    }

    //修改上传数据
    public function updhanddle()
    {
        $data=[
            'app_file' =>input('app_file'),
            'app_number'=>input('app_number'),
            'app_remark'=> input('app_remark'),
            'app_log'=>input('app_log'),
        ];


        $id=input('app_id');
        $validate=validate('History');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('app_history')->where('app_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }

    public function detail()
    {
        $id=input('id');

        $detail=db('app_history')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"app详情");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}