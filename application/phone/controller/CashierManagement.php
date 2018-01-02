<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class CashierManagement extends Controller
{

    public function lst()
    {
        //出纳查询
        $cashier_category = input('cashier_category');
        if ($cashier_category) {
            $myfinance = db('app_cashier_management')
                ->order('cashier_id desc')
                ->where('cashier_category',$cashier_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['cashier_time'] = date('Y-m-d H:i:s',$v['cashier_time']);
                array_push($timedata, $v);
            }
            $mydata['data'] = $timedata;
            return json_encode($mydata);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }

}