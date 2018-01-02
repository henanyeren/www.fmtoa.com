<?php
namespace app\admin\controller;
class Expenses extends Common{
    public function manager()
    {
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        return $re;
    }
    public function add(){
        $this->assign([
            'tabTitle'=>'报销添加',
            'mylist'=>111,
        ]);

        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        return $re;
    }
    public function addhanddle()
    {
        $data=[
            'reimbursement_name'=>input('reimbursement_name'),
            'reimbursement_money'=>input('reimbursement_money'),
            'reimbursement_reason'=>input('reimbursement_reason'),
            'reimbursement_remark'=>input('reimbursement_remark'),
            'reimbursement_img'=>input('reimbursement_img'),
            'reimbursement_names'=>session('admin_id'),
            'reimbursement_voucher'=>input('reimbursement_voucher'),
        ];
        //var_dump($data);die;
        /*$validate=validate('bill_reimbursement');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }*/
        $data['reimbursement_time']=time();
        $re=db('bill_reimbursement')->insert($data);

        if($re){
            return array('state'=>0,'msg'=>'报销明细添加成功');
        }else{
            return array('state'=>0,'msg'=>'报销明细添加失败');
        }
        return ;
    }

    public function lst(){
        $data=model('bill_reimbursement')->order('reimbursement_id desc')->select();
        foreach ($data as $v){
            $v->expenses;
        }
        $data=$data->toArray();

        $this->assign([
            'list'=>$data,
            'tabTitle'=>'报销费用明细表'
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        if(request()->isAjax()){
            return $re;
        }
    }
    public function upd(){
        $id=input('id');
        $mydate=db('bill_reimbursement')->where('reimbursement_id',$id)->find();

        $this->assign([
            'detail_info'=>$mydate,
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        if(request()->isAjax()){
            return $re;
        }
    }

    public function updhanddle(){
        $data=[
            'reimbursement_name'=>input('reimbursement_name'),
            'reimbursement_money'=>input('reimbursement_money'),
            'reimbursement_reason'=>input('reimbursement_reason'),
            'reimbursement_remark'=>input('reimbursement_remark'),
            'reimbursement_img'=>input('reimbursement_img'),
            'reimbursement_names'=>session('admin_id'),
            'reimbursement_voucher'=>input('reimbursement_voucher'),
        ];
       /* $validate=validate('DepotMateriels');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }*/
         $id=input('reimbursement_id');

        $re=db('bill_reimbursement')->where('reimbursement_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'报销费用修改成功');
        }else{
            return array('state'=>0,'msg'=>'报销费用修改失败');
        }
        return ;
    }


    public function detail(){
        $id=input('id');
        $detail=model('bill_reimbursement')->where('reimbursement_id',$id)->find();

        $detail->expenses;
        $detail=$detail->toArray();

        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"报销详细信息");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

    public function del(){
        $id=input('reimbursement_id');
        $mydata = db('bill_reimbursement')->delete($id);
        if ($mydata) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
     public function generate(){
         $re=[
             'status'=>1,
             'page'=>$this->fetch(),
         ];

         if(request()->isAjax()){
             return $re;
         }
     }


     public function generatehanddle(){
         $data['monthly_time']=strtotime(input('time'));
         $data['monthly_times']=strtotime(input('times'));
         $data['monthly_remark']=input('monthly_remark');
         $mydate=db('bill_reimbursement')
             ->where('reimbursement_time','>',$data['monthly_time'])
             ->where('reimbursement_time','<',$data['monthly_times'])
             ->field('reimbursement_id')
             ->select();
         if($mydate) {
             $a = array();
             foreach ($mydate as $v) {
                 $a[] = $v['reimbursement_id'];
             }
             $data['monthly_pid'] = implode($a, ',');
             $mydata=db('bill_monthly')->insertGetId($data);

//生成模板
             $id=$mydata;
             $detail=db('bill_monthly')->find($id);
             $where='reimbursement_id in('.$detail['monthly_pid'].')';
             $detail['monthly_pid']=db('BillReimbursement')->where($where)->select();
             $detail['money']=0;
                 foreach ($detail['monthly_pid'] as $v){
                     $detail['money']+=$v['reimbursement_money'];
                 }
                 $this->assign('detail',$detail);
                $page=$this->fetch('querydetail');
//调用word方法生成word文件
             $files=DS."case".DS.$data['monthly_remark'].time().'.doc';
             $file="public".$files;
             $this->words($page,$file);
             $monthly_file=$files;

             $mydatas = db('bill_monthly')->where('monthly_id',$id)->update(['monthly_file'=>$monthly_file]);

             if($mydatas) {
                 return array('state' => 1, 'msg' => '账单生成成功');
             }else{
                 return array('state'=>0,'msg'=>'账单生成失败');
             }
         }else{
             return array('state'=>0,'msg'=>'未查到信息');
         }
     }

    public function query(){
        $data=db('bill_monthly')->order('monthly_id desc')->select();
        $this->assign([
            'list'=>$data,
            'tabTitle'=>'月账单明细表'
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        if(request()->isAjax()){
            return $re;
        }
    }

    public function querydetail(){
        $id=input('id');
        $detail=db('bill_monthly')->find($id);
        $where='reimbursement_id in('.$detail['monthly_pid'].')';
        $detail['monthly_pid']=db('BillReimbursement')->where($where)->select();

        if($detail){
            $detail['money']=0;
            foreach ($detail['monthly_pid'] as $v){
                $detail['money']+=$v['reimbursement_money'];
            }
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch());
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

    public function querydel(){
        $id=input('monthly_id');
        $mydata = db('bill_monthly')->delete($id);
        if ($mydata) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }

    public function checkAjax(){

    }
    public function addfile(){
            $id=input('id');
            $this->assign([
                'monthly_id'=>$id,
            ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
            if(request()->isAjax()){
               return $re;
            }
    }
    public function addfilehandle(){
        $id=input('monthly_id');
        $monthly_file=input('monthly_file');
        if(request()->isAjax()){
            $mydata = db('bill_monthly')->where('monthly_id',$id)->update(['monthly_file'=>$monthly_file]);
            if($mydata) {
                return array('state' => 1, 'msg' => '文件添加成功');
            }else{
                return array('state'=>0,'msg'=>'文件添加失败');
            }
        }
    }

    public function uploads(){
// 获取表单上传文件 例如上传了001.jpg
        $finance = request()->file('thumb');
        $finance_img="public".DS."expenses";
        $finances_img=DS."expenses";
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

}