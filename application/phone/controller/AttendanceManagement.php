<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class AttendanceManagement extends Controller
{

    public function lst()
    {
        //考勤查询
        $attendance_category = input('attendance_category');
        if ($attendance_category) {
            $myfinance = db('app_attendance_management')
                ->order('attendance_id desc')
                ->where('attendance_category',$attendance_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['attendance_time'] = date('Y-m-d H:i:s',$v['attendance_time']);
                array_push($timedata, $v);
            }
            $mydata['data'] = $timedata;
            return json_encode($mydata);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
    public function one(){
        //查出详细信息
        $attendance_id=input('attendance_id');
        if(isset($attendance_id)){
            $myfinance = db('app_attendance_management')
                ->where('attendance_id', $attendance_id)
                ->find();
         $myfinance['attendance_time']=date('Y-m-d H:i:s',$myfinance['attendance_time']);
         $myfinance['state']='200';
           return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}