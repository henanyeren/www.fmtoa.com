<?php
namespace app\admin\model;
use \think\Model;

class DepotPressMateriels extends Model
{
	protected $resultSetType='collection';
    public function DepotPressMaterielsGoods(){
    	//返回库单和物体的数据
    	//$this->hasOne('Admin','admin_id','materiel_bodily_destination');
    	return $this->hasMany('DepotPressMaterielsGoods','materiel_main_table_pid','materiel_id');
    }
	//获取
    public function Qc(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_qc_id');
    }
    //获取需求者
    public function Demander(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_demander_id');
    }    

    //获取仓管
    public function Godownkeeper(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_godown_keeper');
    }       
    //获取发放人
    public function Lssuer(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_lssuer');
    }       
    
    //获取进出库表类型
    public function DepotpressType(){
    	//返回库单和物体的数据
    	return $this->hasOne('DepotPressType','type_id','materiel_type');
    }  
    
    
    //获取生产部
    public function ProductDepartment(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_product_department');
    }  

    //获取退库人
    public function cancellingStocks(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_cancelling_stocks_id');
    }  
        
    //获取收货人
    public function ReceiverId(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_receiver_id');
    }  
        
    
    //获取采购人
    public function Purchaser(){
    	//返回库单和物体的数据
    	return $this->hasOne('Admin','admin_id','materiel_purchaser');
    }  

	//关联得到我的我的事务表
    public function MyRoutine(){
    	return $this->hasOne('MyRoutine','routine_id','requisitionl_routine_id');
    }	        

	//销售去向
    public function AalesTo(){
    	return $this->hasOne('Admin','admin_id','materiel_sales_to');
    }	  

	//出库人
    public function MaterielOutboundPersonId(){
    	return $this->hasOne('Admin','admin_id','materiel_outbound_person_id');
    }	 
    
    
 
   
}	