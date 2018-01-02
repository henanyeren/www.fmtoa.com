<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Video extends Common
{
    public function add(){

        if(request()->post()) {
            $videodata['video_url'] = input('video_url');
            $videodata['video_name']=input('video_name');
            $videodata['video_time'] = time();
            $videodata['video_preview']=input('video_preview');
            $videodata['video_title'] = input('video_title');
            $res = db('video')->insert($videodata);
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
        $myvideo=db('video')->order('video_id desc')->select();
        $this->assign('myvideo',$myvideo);
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
        $id = input('video_id');
        $myvideo = db('video')->delete($id);
        if ($myvideo) {
            return array('state' => 1, 'msg' => '删除成功！');
        } else {
            return array('state' => 0, 'msg' => '删除失败!');
        }
    }
    public function upload(){
       if(request()->isAjax()){
           $validate=\think\Loader::validate('Video');
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
       $video = request()->file('thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下

     //获取文件名字
     /*   $myvideo=$video->getInfo();
        $name=$myvideo['name'];
        $a=db('video')->where('video_name',$name)->find();*/
            $videodata['video_time']=date('Y-m-d',time());
            $video_img="public".DS."videopropagete".DS."img".DS.$videodata['video_time'];
            $videos_img=DS."videopropagete".DS."img".DS.$videodata['video_time'];
            $info_img = $video->move(ROOT_PATH .$video_img,'');
            if($info_img){
                $address=$videos_img.DS.$info_img->getSaveName();
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
        $detail_info=db('video')->find($id);
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
            'video_url' =>input('video_url'),
       'video_name'=>input('video_name'),
        'video_title'=> input('video_title'),
            'video_preview'=>input('video_preview')
        ];


        $id=input('video_id');
       $validate=validate('Video');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $re=db('video')->where('video_id',$id)->update($data);
        if($re){
            return array('state'=>1,'msg'=>'修改成功');
        }else{
            return array('state'=>0,'msg'=>'修改失败');
        }
    }
    public function detail()
    {
        $id=input('id');

        $detail=db('video')->find($id);
        if($detail){
            $this->assign('detail',$detail);
            return array('state'=>'1','msg'=>$this->fetch(),'name'=>"视频详情");
        }else{
            return array('state'=>'0','msg'=>'查询错误');
        }
    }

}