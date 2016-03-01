<?php

// 产线提货
class ProductionOut extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('inventorytransaction');
      $this->load->model('productionbatch');
      $this->load->model('common');
      $this->helper->chechActionList(array('productionOut'),true);
	
    }
    
    public function supplies() {
    	$cond = array();
    	$facility_list = $this->common->getFacilityList();
    	$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
    	$cond['product_type'] = 'supplies';
    	$this->helper->chechActionList(array('suppliesInventoryManager'),true);
        $out = $this->inventorytransaction->getCanSaleProductList($cond);
        if (isset($out['error_info'])) {
        	var_dump($out['error_info']);
        	die("错误");
        } else {
        	$cond['product_list'] = $out['data']['product_list'];
        }
        
        
        $cond['facility_list'] = $facility_list['data'];
        $data = $this->helper->merge($cond); 
        $this->load->view('production_out_supplies',$data);
    	
    }
    
    public function createProductionOutSuppliesTransaction() {
    	$cond = array();
    	$cond['facility_id'] = $this->input->post("hidden_facility_id");
    	
    	$cond['container_code'] = $this->input->post("container_code");
    	$cond['real_quantity'] = $this->input->post("real_quantity");

    	
    	if (empty ($cond['container_code']) || empty($cond['real_quantity'])) {
    		echo "请输入数量";
    		die();
    	}
    	$out = $this->inventorytransaction->createProductionOutTransaction($cond);
    	if (isset($out['error_info'])) {
    		echo json_encode(array("error_info" => "入库失败：" . $out['error_info']));
    	} else {
    		echo json_encode(array("success" => 'success'));
    	}
    	
    }
    
    public function index() {
    	$cond = array();
        $pb_sn = $this->getInput('pb_sn');
        $facility_id = $this->getInput('facility_id');
        $this->helper->chechActionList(array('wuliaoManager'),true);
        if ($pb_sn && $facility_id) {
        	$cond['pb_sn'] = $pb_sn;
        	$cond['facility_id'] = $facility_id;
        	$out = $this->productionbatch->getProductionBatch($pb_sn,$cond);
        	if (isset($out['error_info'])) {
        		//$cond['message'] = $out['message'];
        		echo $out['error_info'] . "<br/>";
        	} else {
        		$cond['production_batch'] = $out['data']['production_batch'];
        		$cond['item_list'] = $out['data']['production_batch_item_list'];
        		if (empty($cond['production_batch']) || empty($cond['item_list'])) {
        			die("无法获取单据");
        		}
        	}
        }
        
    	$facility_list = $this->common->getFacilityList();
        $cond['facility_list'] = $facility_list['data'];
        $facility_list = $this->common->getFacilityList();
	  	if(isset($facility_list['data'])){
	  		$cond['multi_facility'] = (count($facility_list['data'])>1)? 1:0;
	  	}
        $data = $this->helper->merge($cond); 
        $this->load->view('production_out',$data);
    }
    
    public function getLoadingBillItem() {
    	$cond = array();
    	$cond['bol_id'] = $this->getInput('bol_id');
    	$cond['container_code'] = $this->getInput('container_code');
    	$out = $this->loadingbill->getLoadingBillItem($cond);
    	if (isset($out['error_info'])) {
    		echo json_encode($out);
    	} else {
    		$loading_bill_item = $out['data']['loading_bill_item'][0];
	    	echo json_encode($loading_bill_item);
    	}
    }
    
     // 从 get 或 post 获取数据 优先从 post 没有返回 null 
    private function getInput($name) {
        $out = $this->input->post($name);
		if(is_array($out)){
			return $out;
		} else {
			$out = trim( $out );
		}
	
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
    }
    
    
    public function packagePickUp(){
  	$facility_list = $this->common->getFacilityList();
  	if (isset($facility_list['error_info'])) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'获取不到当前仓库' ) );
  		return false;;
  	} else {
  		if(isset($facility_list['data']) && count($facility_list['data']) > 1){
  			echo json_encode( array( "success" => 'fail','error_info'=>'多仓库权限不能操作' ) );
  			return false;;
  		}
  	}
  	
  	$production_batch_item_id = $this->getInput('production_batch_item_id');
  	if(!isset($production_batch_item_id)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'提库存失败' ) );
  		return false;;
  	}
  	
  	$quantity = $this->getInput('quantity');
  	if(isset($quantity)) {
  		$cond['quantity'] = $quantity;
  	} else{
  		echo json_encode( array( "success" => 'fail','error_info'=>'数量不能为空' ) );
  		return false;;
  	}
  	
  	$out = $this->productionbatch->packagePickUp( $production_batch_item_id, $cond );
  	if($out['result'] == 'ok'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
  	}
  }
  
  public function materialPickUp(){
  	$facility_list = $this->common->getFacilityList();
  	if (isset($facility_list['error_info'])) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'获取不到当前仓库' ) );
  		return false;;
  	} else {
  		if(isset($facility_list['data']) && count($facility_list['data']) > 1){
  			echo json_encode( array( "success" => 'fail','error_info'=>'多仓库权限不能操作' ) );
  			return false;;
  		}
  	}
  	
  	$production_batch_item_id = $this->getInput('production_batch_item_id');
  	if(!isset($production_batch_item_id)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'提库存失败' ) );
  		return false;;
  	}
  	 
  	$items = $this->getInput('items');
  	if(!isset($items)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'数量不能为空' ) );
  		return false;
  	} 
  	$out = $this->productionbatch->materialPickUp( $production_batch_item_id, $items );
  	if($out['result'] == 'ok'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
  	}
  }
}
?>