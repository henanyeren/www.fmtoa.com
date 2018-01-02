<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Apply extends Common
{
    public function add(){

        if(request()->post()) {
            $imgdata['apply_url'] = input('apply_url');
            $imgdata['apply_name']=preg_replace('/^.+[\\\\\\/]/', '',$imgdata['apply_url']);
            $imgdata['apply_time'] = time();
                $res = db('app_apply')->insert($imgdata);
                if ($res) {
                return array('state'=>1,'msg'=>'添加成功！');
            } else {
                return array('state'=>1,'msg'=>'添加失败');
            }
        }

        $re=[
            'status'=>1,
            'page'=>$this->fetch('add'),
        ];
        return $re;

    }

    public function lst(){
        $myimg=db('app_apply')->order('apply_id desc')->select();
        $this->assign('data',$myimg);
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
        $id = input('apply_id');
        $myimg = db('app_apply')->delete($id);
        if ($myimg) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
        return array('state'=>'1','msg'=>'可以使用');
    }
    public function uploads(){
        // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下

     //获取文件名字
        $myimg=$file->getInfo();
        $name=$myimg['name'];
        $a=db('app_apply')->where('apply_name',$name)->find();
        $imgdata['apply_time']=date('Y-m-d',time());
        if($a){
            $b[0]="<script>alert('文件已存在！请修改名字在上传！');</script>";
            $b[1]=0;
           return $b;
        }else{
            $file_img="public".DS."apply".DS.$imgdata['apply_time'];
            $files_img=DS."apply".DS.$imgdata['apply_time'];
            $info_img = $file->move(ROOT_PATH.$file_img,'');
            if($info_img){
                $address=$files_img.DS.$info_img->getSaveName();
                $b[0]="<script>alert('文件上传成功！');</script>";
                $b[1]=$address;
                return $b;
            }else{
                $b[0]="<script>alert('文件上传失败请重试！');</script>";
                $b[1]=0;
                return $b;
            }
        }
    }
    //修改获取页面
    public function upd()
    {
        $id=input('id');
        $detail_info=db('app_apply')->find($id);
        $this->assign('apply',$detail_info);

        $re=[
            'status'=>1,
            'page'=>$this->fetch('upd'),
        ];

        return $re;
    }

    //修改上传数据
    public function updhanddle()
    {
        $data['apply_url'] = input('apply_url');
        //截取文件名
        $data['apply_name']=preg_replace('/^.+[\\\\\\/]/', '',$data['apply_url']);

        $id = input('apply_id');

        $re=db('app_apply')->where('apply_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('app_apply')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"图片预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}