<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class OrdersNotInFacilityRegion extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model("order");
	    $this->helper->chechActionList(array('productionPlan'),true);
	}

	private function getQueryCondition( ){
		$cond = array( );

		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取当前仓库";
		}
		return $cond;
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			return $out;
		}
		$out = trim($out);
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
  	$cond = $this->initData();
  	if(!empty($cond['error']) && $cond['error'] = 'error'){
  		echo 'ERROR!'.$cond['error_info'];
  		return;
  	}
  	
  	$orderList = $this->order->getOrderNoteInFacilityRegion($cond['facility_id']);
  	$cond['order_list'] = $orderList;
  	$data = $this->helper->merge($cond);
	$this->load->view('orders_not_in_facility_region.php', $data);
  }
  
  public function initData(){
  	$initData = array();
  	$facility_list = $this->common->getFacilityList();
  	if(!empty($facility_list['data'][0]['facility_id'])) {
  		$initData['facility_id'] = $facility_list['data'][0]['facility_id'];
  		$initData['facility_list'] = $facility_list['data'];
  	} else{
  		$initData['error'] = 'error';
  		$initData['error_info'] = '账号无仓库权限';
  		return $initData;
  	}
  	$facility_id = $this->getInput('facility_id');
  	if(!empty($facility_id)) {
  		$initData['facility_id'] = $facility_id; 
  	}
  	
  	$initData['asn_date'] = date('Y-m-d');
  	return $initData;
  }
  
}
?>