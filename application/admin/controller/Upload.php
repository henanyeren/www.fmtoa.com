<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Upload extends Controller
{
    public function add(){

        if(request()->post()) {
            $filedata['file_url'] = input('file_url');
           // $filedata['file_name']=basename($filedata['file_url']);
            $filedata['file_name']=preg_replace('/^.+[\\\\\\/]/', '',$filedata['file_url']);

                $filedata['file_time'] = time();
                $filedata['file_content'] = input('file_content');
                $res = db('file')->insert($filedata);
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
        $myfile=db('file')->order('file_id desc')->select();
        $this->assign('myfile',$myfile);
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
        $id = input('file_id');
        $myfile = db('file')->delete($id);
        if ($myfile) {
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
        $myfile=$file->getInfo();
        $name=$myfile['name'];
        $a=db('file')->where('file_name',$name)->find();
        $filedata['file_time']=date('Y-m-d',time());
        if($a){
            $b[0]="<script>alert('文件已存在！请修改名字在上传！');</script>";
            $b[1]=0;
           return $b;
        }else{
            $file_img="public".DS."company".DS."img".DS.$filedata['file_time'];
            $files_img=DS."company".DS."img".DS.$filedata['file_time'];
            $info_img = $file->move(ROOT_PATH .$file_img,'');
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
        $detail_info=db('file')->find($id);
        $this->assign('files',$detail_info);

        $re=[
            'status'=>1,
            'page'=>$this->fetch('upd'),
        ];

        return $re;
    }

    //修改上传数据
    public function updhanddle()
    {
        $data['file_url'] = input('file_url');
        // $filedata['file_name']=basename($filedata['file_url']);
        //截取文件名
        $data['file_name']=preg_replace('/^.+[\\\\\\/]/', '',$data['file_url']);

        $id = input('file_id');
        $data['file_content'] = input('file_content');
        /*$validate=validate('AppNotice');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }*/
        $re=db('file')->where('file_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }

}