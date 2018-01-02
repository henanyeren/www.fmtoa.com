<?php
	namespace app\admin\controller;
	use think\Controller;

	class Cost extends Common
    {

        public function borrow()
        {
            $re = [
                'state' => 1,
                'page' => $this->fetch(),
            ];
            return $re;
        }

        public function borrowhanddle(){
            $data=[
                'borrow_duty'=>input('borrow_duty'),
                'borrow_dutys'=>input('borrow_dutys'),
                'borrow_name'=>input('borrow_name'),
                'borrow_reason'=>input('borrow_reason'),
                'borrow_money'=>input('borrow_money'),
                'borrow_moneys'=>input('borrow_moneys'),
            ];
            $validate=\think\Loader::validate('Cost');
            if(!$validate->scene('borrow')->check($data)){
                return array('state'=>'0','msg'=>$validate->getError());
            }else{
                $data['borrow_time']=time();
                $re=db('cost_borrow')->insert($data);
                if($re) {
                    return array('state' => '1', 'msg' => '申请成功！！');
                }else{
                    return  array('state'=>'0','msg'=>'申请失败，请重新申请');
                }
            }
        }

        public function borrow_lst(){
            $where=[
                'borrow_name'=>session('admin_id'),
            ];
          $data= db('cost_borrow')->where($where)->select();
            $this->assign([
                'list'=>$data,
                'tabTitle'=>'借支申请列表',
            ]);

            $re=[
                'status'=>1,
                'page'=>$this->fetch(),
            ];
            if(request()->isAjax()){
                return $re;
            }
        }
        public function borrow_detail(){
            $where=[
                'borrow_name'=>session('admin_id'),
                'borrow_id'=>input('id'),
            ];

            $data= db('cost_borrow')->alias('a')->where($where)
                ->join('admin b','a.borrow_name=b.admin_id')
                ->find();
            unset($data['admin_password']);
            unset($data['admin_random_number']);
            $this->assign('data',$data);
            $re=[
                'status'=>1,
                'msg'=>$this->fetch(),
            ];
            if(request()->isAjax()){
                return $re;
            }
        }

        public function fund_payment(){
            $re = [
                'state' => 1,
                'page' => $this->fetch(),
            ];
            return $re;
        }

        public function fundPaymenthanddle(){
            $data=[
                'fund_number'=>input('fund_number'),
                'fund_payment_unit'=>input('fund_payment_unit'),
                'fund_duty'=>input('fund_duty'),
                'fund_name'=>input('fund_name'),
                'fund_reason'=>input('fund_reason'),
                'fund_money'=>input('fund_money'),
                'fund_moneys'=>input('fund_moneys'),
                'fund_receivables'=>input('fund_receivables'),
            ];
            $validate=\think\Loader::validate('Cost');
            if(!$validate->scene('fund')->check($data)){
                return array('state'=>'0','msg'=>$validate->getError());
            }else{
                $data['fund_time']=time();
                $re=db('cost_fund_payment')->insert($data);
                if($re) {
                    return array('state' => '1', 'msg' => '申请成功！！');
                }else{
                    return  array('state'=>'0','msg'=>'申请失败，请重新申请');
                }
            }
        }

        public function fund_lst(){
            $where=[
                'fund_name'=>session('admin_id'),
            ];
            $data= db('cost_fund_payment')->where($where)->select();
            $this->assign([
                'list'=>$data,
                'tabTitle'=>'借支申请列表',
            ]);

            $re=[
                'status'=>1,
                'page'=>$this->fetch(),
            ];
            if(request()->isAjax()){
                return $re;
            }
        }
        public function fund_detail(){
            $where=[
                'fund_name'=>session('admin_id'),
                'id'=>input('id'),
            ];

            $data= db('cost_fund_payment')->alias('a')->where($where)
                ->join('admin b','a.fund_name=b.admin_id')
                ->find();
            //dump($data);
            unset($data['admin_password']);
            unset($data['admin_random_number']);
            $this->assign('data',$data);
            $re=[
                'status'=>1,
                'msg'=>$this->fetch(),
            ];
            if(request()->isAjax()){
                return $re;
            }
        }
        public function payment(){
            $re = [
                'state' => 1,
                'page' => $this->fetch(),
            ];
            return $re;
        }

        public function Paymenthanddle(){
            $data=[
                'payment_number'=>input('payment_number'),
                'payment_contract'=>input('payment_contract'),
                'payment_duty'=>input('payment_duty'),
                'payment_name'=>input('payment_name'),
                'payment_reason'=>input('payment_reason'),
                'payment_money'=>input('payment_money'),
                'payment_moneys'=>input('payment_moneys'),
                'payment_receivables'=>input('payment_receivables'),
                'payment_proportion'=>input('payment_proportion'),
                'payment_actual_proportion'=>input('payment_actual_proportion'),
            ];
            $validate=\think\Loader::validate('Cost');
            if(!$validate->scene('payment')->check($data)){
                return array('state'=>'0','msg'=>$validate->getError());
            }else{
                $data['payment_time']=time();
                $re=db('cost_payment')->insert($data);
                if($re) {
                    return array('state' => '1', 'msg' => '申请成功！！');
                }else{
                    return  array('state'=>'0','msg'=>'申请失败，请重新申请');
                }
            }
        }

        public function payment_lst(){
            $where=[
                'payment_name'=>session('admin_id'),
            ];
            $data= db('cost_payment')->where($where)->select();
            $this->assign([
                'list'=>$data,
                'tabTitle'=>'付款申请列表',
            ]);

            $re=[
                'status'=>1,
                'page'=>$this->fetch(),
            ];
            if(request()->isAjax()){
                return $re;
            }
        }

        public function payment_detail(){
            $where=[
                'payment_name'=>session('admin_id'),
                'id'=>input('id'),
            ];

            $data= db('cost_payment')->alias('a')->where($where)
                ->join('admin b','a.payment_name=b.admin_id')
                ->find();
            //dump($data);
            unset($data['admin_password']);
            unset($data['admin_random_number']);
            $this->assign('data',$data);
            $re=[
                'status'=>1,
                'msg'=>$this->fetch(),
            ];
            if(request()->isAjax()){
                return $re;
            }
        }

        public function manager(){
            if(request()->isAjax()){
                $re = [
                    'state' => 1,
                    'page' => $this->fetch(),
                ];
                return $re;
            }
        }
        public function checkajax(){
            if(request()->isAjax()){
                $validate=\think\Loader::validate('Cost');
                $mypost=request()->post();
                $mykey=array_keys($mypost)[0];
                if(!$validate->scene($mykey)->check($mypost)){
                    return array('state'=>'0','msg'=>$validate->getError());
                }else{
                    return array('state'=>'1','msg'=>'可以使用');
                }
            }
        }

        public function money(){
            if(request()->isAjax()){
             $a=input('post.');
            $number=$this->mynumber($a['number']);
                $re = [
                    'state' => 1,
                    'number' => $number,
                ];
             return $re;
            }
        }

    }
