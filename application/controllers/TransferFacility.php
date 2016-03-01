<?php 

class TransferFacility extends CI_Controller {
	function __construct(){
		parent::__construct();
	  	$this->load->library('session');
		$this->load->model('common');
		$this->load->model('facility');
		$this->load->model('productmodel');
	}
	
	public function index() {
		//获取仓库
		
	}
	public function transferFacility(){
		$out = $this->facility->getAllFacility();
		$data = $out['data'];		
		$data = $this->helper->merge($data);
		$this->load->view("transfer_facility",$data);
	}
	public function transferShipping(){
		$out = $this->facility->getAllFacility();
		$data = $out['data'];		
		$data = $this->helper->merge($data);
		$this->load->view("transfer_shipping",$data);
	}
	
	public function getProductList() {
		$facility_id = $this->getInput('facility_id');
		$cond['facility_id'] = $facility_id;
		$data = $this->facility->getAvaiableProduct($facility_id);
		echo  json_encode($data['data']['facility_product_list']);
	}
	
	public function searchProduct() {
		$product_id = $this->getInput('product_id');
		if(isset($product_id)) {
			$cond['product_id'] = $product_id;
		}
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		}
		
		$out = $this->facility->searchProduct($cond);
		if (isset($out['data']['data_list'])) {
			$cond['data_list'] =$out['data']['data_list'];
		}
		$facility_list = $this->facility->getAllFacility();
		$cond['facility_list'] = $facility_list['data']['facility_list'];
		$data = $this->helper->merge($cond);
		$this->load->view("transfer_facility",$data);
	}
	public function getCanTransferData() {
		$product_id = $this->getInput('product_id');
		if(isset($product_id)) {
			$cond['product_id'] = $product_id;
		}

		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		}
		$transfer_type = $this->getInput('transfer_type');
		if(isset($transfer_type)) {
			$cond['transfer_type'] = $transfer_type;
		}

		$out = $this->facility->searchProduct($cond);
		echo json_encode($out);
		
	}
	public function getFacilityListByShippingRule() {
		$product_id = $this->getInput('product_id');
		$province_id = $this->getInput('province_id');
		$exclude_facility_id = $this->getInput('facility_id');
		$out = $this->facility->getFacilityListByShippingRule($product_id,$province_id);
		foreach($out['data']['list'] as $key=>$item){
			if($item['facility_id'] == $exclude_facility_id){
				unset($out['data']['list'][$key]);
			}
		}
		echo json_encode($out);
	}
	
	public function getShippingListByCoverage() {
		$facility_id = $this->getInput('facility_id');
		$province_id = $this->getInput('province_id');
		$exclude_shipping_id = $this->getInput('shipping_id');
		//根据facility_id查找出所有快递方式
		$out = $this->facility->getShippingListByCoverage($facility_id,$province_id);
		foreach($out['data']['list'] as $key=>$item){
			if($item['shipping_id'] == $exclude_shipping_id){
				unset($out['data']['list'][$key]);
			}
		}
		$data = $out['data'];
		echo json_encode($data);
	}
	
	public function transfer() {
		$data = array(
				"from_facility_id" => $this->getInput('from_facility_id'),
				"from_shipping_id" => $this->getInput('from_shipping_id'),
				"product_id" => $this->getInput('product_id'),
				"to_facility_id" => $this->getInput('to_facility_id'),
				"to_shipping_id" => $this->getInput('to_shipping_id'),
				"plan_quantity" => $this->getInput('plan_quantity'),
				"from_province_id" => $this->getInput('from_province_id'),
				"transfer_type" => $this->getInput('transfer_type'),
				"transfer_cod_type" => $this->getInput('transfer_cod_type'),
		);
		$info = $this->facility->transfer($data);
		echo json_encode($info);
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = trim( $this->input->post($name) );
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