<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class CommonProblem extends Common
{
    public function add(){

        if(request()->post()) {
            $data['problem_name'] = input('problem_name');
            $data['problem_content']=input('problem_content');
            $data['problem_time'] = time();
            $res = db('CommonProblem')->insert($data);
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
        $mydate=db('CommonProblem')->order('problem_id desc')->select();
        $this->assign('mydate',$mydate);
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
        $id = input('problem_id');
        $myvideo = db('CommonProblem')->delete($id);
        if ($myvideo) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
       if(request()->isAjax()){
           $validate=\think\Loader::validate('CommonProblem');
           $mypost=request()->post();
           $mykey=array_keys($mypost)[0];
           if(!$validate->scene($mykey)->check($mypost)){
               return array('state'=>'0','msg'=>$validate->getError());
           }else{
               return array('state'=>'1','msg'=>'可以使用');
           }
       }
    }
    //修改获取页面
    public function upd()
    {
        $id=input('id');
        $detail_info=db('CommonProblem')->find($id);
        $this->assign('video',$detail_info);

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
            'problem_name'=> input('problem_name'),
            'problem_content'=>input('problem_content'),
        ];


        $id=input('problem_id');
       $validate=validate('CommonProblem');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('CommonProblem')->where('problem_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('CommonProblem')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"问题详情");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}