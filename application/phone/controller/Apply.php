<?php
namespace app\phone\controller;
use  think\Controller;
class Apply extends Controller{
    public function lst(){
        $myapply=db('app_apply')->order('apply_id desc')->paginate(6);
        if($myapply){
            $mydata = $myapply->toArray();
            $mydata['state'] = '200';
            if ($mydata['total'] == 0){
                return json_encode(array('state' => '204', 'msg' => '暂无数据'));
            }
            $timedata = array();
            foreach ($mydata['data'] as $k => $v) {
                $v['apply_time'] = date('Y-m-d H:i:s',$v['apply_time']);
                array_push($timedata, $v);
            }
            $mydata['data'] = $timedata;
            return json_encode($mydata);

        }else{
            return json_encode(array('data'=>'101','msg'=>'查询错误'));
        }
    }

}