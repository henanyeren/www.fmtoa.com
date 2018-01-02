<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class AttendanceManagement extends Common
{
    public function add(){
        $re=[
            'status'=>1,
            'page'=>$this->fetch('add'),
        ];
        return $re;
    }

    public function addhanddle(){

        $financedata['attendance_url'] = input('attendance_url');
        $financedata['attendance_name']=input('attendance_name');
        $financedata['attendance_category']=input('attendance_category');
        $financedata['attendance_time'] = time();
        $financedata['attendance_content']=input('attendance_content');
        $validate=validate('AttendanceManagement');
        if(!$validate->scene('add')->check($financedata)){
            $this->error($validate->getError());
        }
        $res = db('app_attendance_management')->insert($financedata);
        if ($res) {
            return array('state'=>1,'msg'=>'添加成功！');
        } else {
            return array('state'=>1,'msg'=>'添加失败');
        }
    }


    public function lst(){
        $myfinance=db('app_attendance_management')->order('attendance_id desc')->select();
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
        $id = input('attendance_id');
        $myfinance = db('app_attendance_management')->delete($id);
        if ($myfinance) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
        if(request()->isAjax()){
            $validate=\think\Loader::validate('attendanceManagement');
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
            $finance_img="public".DS."personnel";
            $finances_img=DS."personnel";
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
        $detail_info=db('app_attendance_management')->find($id);
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
            'attendance_url' =>input('attendance_url'),
            'attendance_name'=>input('attendance_name'),
            'attendance_content'=>input('attendance_content'),
            'attendance_category'=>input('attendance_category'),
        ];


        $id=input('attendance_id');
      $validate=validate('AttendanceManagement');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('app_attendance_management')->where('attendance_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('app_attendance_management')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"文档预览");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}