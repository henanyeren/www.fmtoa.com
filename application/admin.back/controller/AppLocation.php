<?php
	
namespace app\admin\controller;
use       think\Controller;
//日考勤
class AppLocation extends Common{
    public function manager()
    {
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        return $re;
    }
    //日考勤列表
	public function lst(){
		    //今日的时间段
			$stime=strtotime(date('Y-m-d', time()))-1;
			$etime=strtotime(date('Y-m-d',strtotime("+1day",time())));
        $where=[
            'location_timestamp'=>['between',[$stime,$etime]]
        ];
        $lst=model('AppLocation')->where($where)->paginate(1);
         $number=count(model('AppLocation')->where($where)->select());
			//dump($list->toarray());exit;
            //关联人名
		    $time=$stime+(9*3600);
			foreach ($lst as $v) { $data=$v->admin; }
            
            /*$hour=
            $minute
            $second*/
            //赋值
			$this->assign([
				'list'=>$lst,
				'tabTitle'=>date('Y-m-d', time()).'考勤--<span style="color: red">已签到'.$number.'人</span>',
				'time'=>$time,
			]);

			$re=[
				'state'=>1,
				'page'=>$this->fetch('lst'),
			];
        
			if(request()->isAjax()){
				return $re;
			}
	}


    public function generate(){
        //查询人员信息  并输出到考勤页面
        $mymodel=model('Admin');
        $data=db('admin')->field('admin_id,admin_duty_superid,admin_name,admin_pid')->select();
        $mypid=$mymodel->adminchile($data);

        $this->assign([
            'pid'=>$mypid,
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        if(request()->isAjax()){
            return $re;
        }
    }
//考勤查询
    public function sign(){
       $a=input('post.');
        $stime=strtotime(date('Y-m-d', time()));
        $where=[
            'location_timestamp'=>['between',[strtotime($a['time']),strtotime($a['times'])]]
        ];
        if($a['name']){
            $where1=[
                'location_admin_id'=>$a['name']
            ];
        }else{
            $where1="";
        }
        $time=$stime+(9*3600);
        $numbers=model('AppLocation')
            ->where($where)
            ->where($where1)
            ->order('location_admin_id')
            ->select();
        foreach ($numbers as $v) {$v->admin; }
        $numbers= $numbers->toArray();

        $this->assign([
            'list'=>$numbers,
            'time'=>$time,
        ]);
       if($numbers){
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];}else{
           $re=[
               'status'=>2,
           ];
       }
        if(request()->isAjax()){
            return $re;
        }
    }


//...
    public function generates(){
            $where=[
                'location_timestamp'=>['between',[strtotime(input('time')),strtotime(input('times'))]]
            ];
        $number=db('AppLocation')
            ->where($where)
            ->group('location_admin_id')
            ->field('location_admin_id,count(location_id)')
            ->select();

        $numbers=model('AppLocation')
            ->where($where)
            ->order('location_admin_id')
            ->select();
        foreach ($numbers as $v) {$v->admin; }
       $numbers= $numbers->toArray();
        $mysign=array();
        foreach ($numbers as $v){
            $mysign[$v['admin']['admin_name']][date("d",$v['location_timestamp'])]=$v;
        }
        dump($mysign);die;
        return array('state'=>1,'msg'=>'报销费用修改失败');
    }


//...
    public function detail(){

        return array('state'=>'1','msg'=>$this->fetch(),'name'=>"报销详细信息");
    }

    public function location(){
        $stime=strtotime(date('Y-m-d', time()));
        $etime=strtotime(date('Y-m-d',strtotime("+1day",time())));
        $first=db('AppLocation')/*->where('location_admin_id',$location_admin_id)*/
                                                ->where('location_timestamp','>=',$stime)
                                                ->where('location_timestamp','<',$etime)
                                                ->find();
      

       $data = db('AppLocationPath')->field('icon,position')->select();

        foreach ($data as $k => $v) {
            $data[$k]['position'] = unserialize($v['position']);
            
        }
        $data = json_encode($data);

        $first = [$first['location_longitude'],$first['location_latitude']];
        $first = json_encode($first);

       
        $this->assign([
            'list'=>$data,
            'first'=>$first
        ]);
        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
        if(request()->isAjax()){
            return $re;
        }
         
    }
    public function months(){

        $re=[
            'status'=>1,
            'page'=>$this->fetch(),
        ];
     return  $re;

        // month(2,2000);
    }
    public function mymonth(){
        //生成上一月份签到表,获取月份天数
        $data=time();
        $mymonth=month(1,2018);
        //获得月签到参数
     //  $mymonth=month(date('m',$data),date('Y',$data));
        $where=[
            'location_timestamp'=>['between',[$mymonth['time'],$mymonth['times']]]
        ];

        //生成要查询的人员名单
        $user=db('admin')->where('admin_state',0)->select();
        static $i=0;
       $mylocation=array();
       $mylocation[0]['month']=$mymonth['month'];
       $mylocation[0]['week']=$mymonth['week'];
        foreach($user as $value){
            //获取月份签到时间
            $mysign=db('AppLocation')->where('location_admin_id',$value['admin_id'])
            ->where($where)->select();
            $myday=explode(',',$mymonth[1]);
            //遍历月份  把每天状态写进去
            foreach ($mysign as $values){
            $number=$values['location_day']-1;
               $myday[$number]=$values['location_state'];
            }
            $mylocation[$i]['mytime']=$myday;
            $mylocation[$i]['myname']=$value['admin_name'];
            $i++;
        }
     // dump($mylocation);
        $this->assign('mysign',$mylocation);
       $re=[
            'status'=>1,
            'page'=>$this->fetch('detail'),
        ];
        if(request()->isAjax()) {
            return $re;
        }
     /*   {volist id="$myname" id="myday"}
        {if condition="$myday eq 1"}
        <td><input name="" type="text" value="√"></td>
                    {else/}
                    <td><input name="" type="text"></td>
                    {/if}
                    {/volist}*/

    }
		
}
