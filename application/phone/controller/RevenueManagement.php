<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class RevenueManagement extends Controller
{

    public function lst()
    {
        //税票查询
        $revenue_category = input('revenue_category');
        if ($revenue_category) {
            $myfinance = db('app_revenue_management')
                ->order('revenue_id desc')
                ->where('revenue_category',$revenue_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['revenue_time'] = date('Y-m-d H:i:s',$v['revenue_time']);
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
        $revenue_id=input('revenue_id');
        if(isset($revenue_id)){
            $myfinance = db('app_revenue_management')
                ->where('revenue_id', $revenue_id)
                ->find();
         $myfinance['revenue_time']=date('Y-m-d H:i:s',$myfinance['revenue_time']);
         $myfinance['state']='200';
           return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}