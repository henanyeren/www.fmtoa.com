<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class CustomerManagement extends Controller
{

    public function lst()
    {
        //税票查询
        $customer_category = input('customer_category');
        if ($customer_category) {
            $myfinance = db('app_customer_management')
                ->order('customer_id desc')
                ->where('customer_category',$customer_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['customer_time'] = date('Y-m-d H:i:s',$v['customer_time']);
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
        $customer_id=input('customer_id');
        if(isset($customer_id)){
            $myfinance = db('app_customer_management')
                ->where('customer_id', $customer_id)
                ->find();
         $myfinance['customer_time']=date('Y-m-d H:i:s',$myfinance['customer_time']);
         $myfinance['state']='200';
           return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}