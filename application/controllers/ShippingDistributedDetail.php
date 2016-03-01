<?php
class ShippingDistributedDetail extends CI_Controller {
	function __construct(){
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model("purchase");
	    
	    $facility_list = $this->common->getFacilityList();
	    if(!isset($facility_list['data'])){
	    	die('无仓库权限');
	    }
	}
	public function index() {
  		$cond = $this->getQueryCondition();
		$distributedList = $this->purchase->getDistributedList($cond);
		$facility_list = $this->common->getFacilityList();
		if (isset($facility_list['error_info'])) {
			$cond['facility_list'] = array();
		} else {
			if(isset($facility_list['data'])){
				$cond['facility_list'] = $facility_list['data'];
			}
		}
		$result = array_merge($distributedList,$cond);
		$data = $this->helper->merge($result);
		$this->load->view('shipping_distributed_detail', $data);
	}
	private function getQueryCondition( ){
		$cond = array();
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		} else {
			$facility_list = $this->common->getFacilityList();
			if (isset($facility_list['error_info'])) {
				$cond['facility_id'] = '';
			} else {
				if(isset($facility_list['data'][0]['facility_id'])){
					$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
				}
			}
		}
		return $cond;
	}
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			$out = implode(',', $out );
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
}
?>
