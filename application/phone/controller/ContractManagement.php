<?php
namespace app\phone\controller;
use think\Controller;
use think\Request;

class ContractManagement extends Controller
{

    public function lst()
    {
        //合同查询
        $contract_category = input('contract_category');
        if ($contract_category) {
            $myfinance = db('app_contract_management')
                ->order('contract_id desc')
                ->where('contract_category',$contract_category)
                ->paginate(6);
            $mydata = $myfinance->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0) {
                return json_encode(array('state' => '204', 'msg' => '还没有报表'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['contract_time'] = date('Y-m-d H:i:s',$v['contract_time']);
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
        $contract_id=input('contract_id');
        if(isset($contract_id)){
            $myfinance = db('app_contract_management')
                ->where('contract_id', $contract_id)
                ->find();
         $myfinance['contract_time']=date('Y-m-d H:i:s',$myfinance['contract_time']);
         $myfinance['state']='200';
           return json_encode($myfinance);
        }else{
            return json_encode(array('state' => '101', 'msg' => '参数错误'));
        }
    }
}