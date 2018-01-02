<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Papers extends Common
  {
    public function add(){

        if(request()->post()) {
            $companydata['papers_path'] = input('papers_path');
            $companydata['papers_name']=input('papers_name');
           // $companydata['company_name']=basename($companydata['company_url']);
            //$companydata['company_name']=preg_replace('/^.+[\\\\\\/]/', '',$companydata['company_url']);
            $companydata['papers_time'] = time();
            $companydata['papers_content'] = input('papers_content');
            $res = db('papers')->insert($companydata);
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
        $mycompany=db('papers')->order('papers_id desc')->select();
        $this->assign('mycompany',$mycompany);
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
        $id = input('papers_id');
        $mycompany = db('papers')->delete($id);
        if ($mycompany) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
        if(request()->isAjax()){
            $validate=\think\Loader::validate('papers');
            $mypost=request()->post();
            $mykey=array_keys($mypost)[0];
            if(!$validate->scene($mykey)->check($mypost)){
                return array('state'=>'0','msg'=>$validate->getError());
            }else{
                return array('state'=>'1','msg'=>'可以使用');
            }
        }
    }
    public function uploads(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下

        //获取文件名字
        $myimg=$file->getInfo();
        $name=$myimg['name'];
        $a=db('papers')->where('papers_name',$name)->find();
        $imgdata['img_time']=date('Y-m-d',time());
        if($a){
            $b[0]="<script>alert('文件名已存在！请修改名字在上传！');</script>";
            $b[1]=0;
            return $b;
        }else{
            $file_img="public".DS."company".DS."papers".DS.$imgdata['img_time'];
            $files_img=DS."company".DS."papers".DS.$imgdata['img_time'];
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
        $detail_info=db('papers')->find($id);
        $this->assign('company',$detail_info);

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
            'papers_path' =>input('papers_path'),
       'papers_name'=>input('papers_name'),
        'papers_content'=> input('papers_content'),
        ];
        $id=input('papers_id');
      $validate=validate('Papers');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('papers')->where('papers_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('papers')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"文档预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}