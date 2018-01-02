<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class TextBlocking extends Common
{
    public function add(){

        if(request()->post()) {
            $companydata['company_url'] = input('company_url');
            $companydata['company_name']=input('company_name');
           // $companydata['company_name']=basename($companydata['company_url']);
            //$companydata['company_name']=preg_replace('/^.+[\\\\\\/]/', '',$companydata['company_url']);
            $companydata['company_time'] = time();
            $companydata['company_content'] = input('company_content');
            $res = db('TextBlocking')->insert($companydata);
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
        $mycompany=db('TextBlocking')->order('company_id desc')->select();
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
        $id = input('company_id');
        $mycompany = db('TextBlocking')->delete($id);
        if ($mycompany) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
        if(request()->isAjax()){
            $validate=\think\Loader::validate('TextBlocking');
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
       $company = request()->file('thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下

     //获取文件名字
     /*   $mycompany=$company->getInfo();
        $name=$mycompany['name'];
        $a=db('company')->where('company_name',$name)->find();*/
            $companydata['company_time']=date('Y-m-d',time());
            $company_img="public".DS."companypropagete".DS.$companydata['company_time'];
            $companys_img=DS."companypropagete".DS.$companydata['company_time'];
            $info_img = $company->move(ROOT_PATH .$company_img,'');
            if($info_img){
                $address=$companys_img.DS.$info_img->getSaveName();
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
        $detail_info=db('TextBlocking')->find($id);
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
            'company_url' =>input('company_url'),
       'company_name'=>input('company_name'),
        'company_content'=> input('company_content'),
        ];


        $id=input('company_id');
      $validate=validate('TextBlocking');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('TextBlocking')->where('company_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('TextBlocking')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"文档预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}