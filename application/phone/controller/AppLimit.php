<?php
namespace app\phone\controller;
use think\Controller;

class AppLimit extends Controller{
	public function duty(){
		$data=db('duty')->select();
		dump($data);
	}
}