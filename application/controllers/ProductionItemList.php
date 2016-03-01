<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ProductionItemList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model("productionbatch");
	    $this->load->model('common');
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
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
	
  public function index()
  {
  	$production_batch_id = $this->getInput('production_batch_id');
  	if(!isset($production_batch_id)){
  		echo '获取提货明细失败';
  		return false;
  	}
  	
  	$facility_list = $this->common->getFacilityList();
  	if(isset($facility_list['data'])){
  		$cond['multi_facility'] = (count($facility_list['data'])>1)? 1:0;
  	}
	
	$out = $this->productionbatch->getProductionItemList( $production_batch_id);
	if($this->helper->isRestOk($out)){
		$cond['item_list'] = $out['data'];
	} else{
		echo $out['error_info'];
		return false;
	}
  	$data = $this->helper->merge($cond);
  	$this->load->view('production_item_list',$data);
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