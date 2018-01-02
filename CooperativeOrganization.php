<?php
namespace app\admin\controller;
use think\Controller;
use Think\Image;
use think\Request;

class CooperativeOrganization extends Common
  {
    public function add(){

        if(request()->post()) {
            $companydata['co_img'] = input('co_img');
            $companydata['co_name']=input('co_name');
            $companydata['co_time'] = time();
            $companydata['co_content'] = input('co_content');

            $thumb_img=\think\Image::open(input('co_img'));
            $thumb_myimg=$thumb_img->thumb(80,60,6)->save(ROOT_PATH ."public"."cooperation".DS."thumb",'','9','false');
            
            $res = db('CooperativeOrganization')->insert($companydata);
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
        $mycompany=db('CooperativeOrganization')->order('co_id desc')->select();
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
        $id = input('co_id');
        $mycompany = db('CooperativeOrganization')->delete($id);
        if ($mycompany) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
        if(request()->isAjax()){
            $validate=\think\Loader::validate('CooperativeOrganization');
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
        // 获取表单上传文件 例如上传了001.jpg9
        $file = request()->file('thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下
            $file_img="public".DS."cooperation";
            $files_img=DS."cooperation";
            $info_img = $file->move(ROOT_PATH .$file_img);
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
    //修改获取页面
    public function upd()
    {
        $id=input('id');
        $detail_info=db('CooperativeOrganization')->find($id);
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
            'co_img' =>input('co_img'),
       'co_name'=>input('co_name'),
        'co_content'=> input('co_content'),
        ];
        $id=input('co_id');
      $validate=validate('CooperativeOrganization');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('CooperativeOrganization')->where('co_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('CooperativeOrganization')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"合作机构");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}