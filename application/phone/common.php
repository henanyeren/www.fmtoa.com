<?php

function getList($brr,$pid=0,&$arr=[],$level=1){
	foreach ($brr as $v) {
		  if ($v['type_pid']==$pid) {
		 
			$v['level']=$level;
			$arr[]=$v;
			getList($brr,$v['type_id'],$arr,$level+1);
		  }
	}
    return  $arr;
}