<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class PersonnelManagement extends Controller
{

    public function lst()
    {
        //人员管理查询
        $personnel_category = input('personnel_category');
        if ($personnel_category) {
            $myfinance = db('app_personnel_management')
                ->order('personnel_id desc')
                ->where('personnel_category',$personnel_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['personnel_time'] = date('Y-m-d H:i:s',$v['personnel_time']);
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
        $personnel_id=input('personnel_id');
        if(isset($personnel_id)){
            $myfinance = db('app_personnel_management')
                ->where('personnel_id', $personnel_id)
                ->find();
            $myfinance['personnel_time']=date('Y-m-d H:i:s',$myfinance['personnel_time']);
            $myfinance['state']='200';
            return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }

}