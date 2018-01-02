<?php
namespace app\phone\controller;
use think\Controller;
use app\admin\model;
class Notification extends Controller{
    public function addhanddle(){
        //接收通知  发送通知
        $user_id=input('user_id');
        if (isset($user_id)){
            $data['notification_release']=$user_id;
            $data['notification_content']=input('content');
            $data['notification_duty_id']=input('superid');
            $data['notification_time']=time();
            if (db('app_notification')->insert($data)){
                return json_encode(array('state'=>'200','msg'=>'发送成功'));
            }else{
                return json_encode(array('state'=>'101','msg'=>'发送失败'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
    }
    public function lst(){
        //获取当前账号的通知
        $user_id=input('user_id');//获取账号id
       $superid=input('superid');//获取职务id
        $len=strlen($superid);
    if($len>1) {
        $id = $this->lstsuperid($superid,$len);
    }else{
        $id=$superid;
    }
        if(isset($superid)){
            $myinfo=db('app_information')->where('information_user_id',$user_id)->buildSql();
           $list= db('app_notification')->alias('a')
               ->order('notification_id desc')
               ->where('notification_duty_id','in',$id)
               ->join([$myinfo=>'b'],'a.notification_id = b.information_notification_id','LEFT')
               ->paginate(10);
           $mylist=$list->toArray();
           if($mylist['total']!=0){
               $timedata=array();
               foreach ($mylist['data'] as $k=>$v){
                   $v['notification_time']=date('Y-m-d H:i:s',$v['notification_time']);
                   array_push($timedata,$v);
               }
               $mylist['state']='200';
               $mylist['data']=$timedata;
               return json_encode($mylist);
           }else{
               return json_encode(array('state'=>'204','msg'=>'你还没有收到通知！！'));
           }
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }
    }

    public function lstsuperid($superid,$len){
        static $id=array();
      /*  if($len>0){
            $id[]=substr($superid, 0, $len);
          $this->lstsuperid($superid,$len-2);
        }*/
      $myid=explode('-',$superid);

      for ($i=0;$i<count($myid);$i++){
          $my='';
          for($j=0;$j<count($myid)-$i;$j++){
              $my=$my.'-'.$myid[$j];
          }
          $id[]=trim($my,'-');
      }
      $id[]=0;
     // dump($id);die;

        return $id;
    }

    public function unread(){
        //获取未读信息数量
        $user_id=input('user_id');//获取账号id
        $superid=input('superid');//获取职务id
        $len=strlen($superid);
        if($len>1) {
            $id = $this->lstsuperid($superid,$len);
        }else{
            $id=$superid;
        }
        if(isset($user_id)) {
            $myinfo = db('app_notification')->where('notification_duty_id','in',$id)->select();

            $list = db('app_notification')->alias('a')
                ->where('notification_duty_id','in',$id)
                ->join('app_information b', 'a.notification_id = b.information_notification_id')
                ->where('b.information_user_id', $user_id)
                ->select();
                $number=count($myinfo)-count($list);
                return json_encode(array('state'=>'200','data'=>$number));
        }else{
            return json_encode(array('state'=>'101','msg'=>'参数错误'));
        }


    }

    public function havereceived(){
        //获取点击收到信息
        $data['information_notification_id']=input('notification_id');
        $data['information_user_id']=input('user_id');
        $data['information_time']=time();
        if (isset($data['information_notification_id']) && isset($data['information_user_id'])){
            $where=[
                'information_notification_id'=>$data['information_notification_id'],
                'information_user_id'=>$data['information_user_id'],
            ];
            if(db('app_information')->where($where)->select()){
                return json_encode(array('state'=>'101','msg'=>'请刷新后重试！！！'));
            }
            if(db('app_information')->insert($data)){
                return json_encode(array('state'=>'200','msg'=>'OK'));
            }else{
                return json_encode(array('state'=>'101','msg'=>'error'));
            }
        }else{
            return json_encode(array('state'=>'101','msg'=>'非法参数！'));
        }
    }

}