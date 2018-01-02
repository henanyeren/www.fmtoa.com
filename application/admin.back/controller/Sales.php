<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Sales extends Common
{
    public function add(){
        $re=[
            'status'=>1,
            'page'=>$this->fetch('add'),
        ];
        return $re;
    }

    public function addhanddle(){

        $financedata['sales_url'] = input('sales_url');
        $financedata['sales_name']=input('sales_name');
        $financedata['sales_category']=input('sales_category');
        $financedata['sales_time'] = time();
        $financedata['sales_content']=input('sales_content');
        $validate=validate('Sales');
        if(!$validate->scene('add')->check($financedata)){
            $this->error($validate->getError());
        }
        $res = db('app_sales')->insert($financedata);
        if ($res) {
            return array('state'=>1,'msg'=>'添加成功！');
        } else {
            return array('state'=>1,'msg'=>'添加失败');
        }
    }


    public function lst(){
        $myfinance=db('app_sales')->order('sales_id desc')->select();
        $this->assign('myfinance',$myfinance);
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
        $id = input('sales_id');
        $myfinance = db('app_sales')->delete($id);
        if ($myfinance) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
        if(request()->isAjax()){
            $validate=\think\Loader::validate('Sales');
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
       $finance = request()->file('thumb');
            $finance_img="public".DS."sales";
            $finances_img=DS."sales";
            $info_img = $finance->move(ROOT_PATH .$finance_img);
            if($info_img){
                $address=$finances_img.DS.$info_img->getSaveName();
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
        $detail_info=db('app_sales')->find($id);
        $this->assign('finance',$detail_info);

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
            'sales_url' =>input('sales_url'),
            'sales_name'=>input('sales_name'),
            'sales_content'=>input('sales_content'),
            'sales_category'=>input('sales_category'),
        ];


        $id=input('sales_id');
      $validate=validate('Sales');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('app_sales')->where('sales_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('app_sales')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"文档预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}