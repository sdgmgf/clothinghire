<?php

class AddFacility extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('region');
		$this->load->model('Productmodel');
		$this->load->model('facility');
		$this->load->model('shipping_template_model');
	}
	
	public function index() {
		$data = array();
		$areaList = $this->common->getAreaList();
        $province_list = $this->region->getRegion(1, 1);
        $data['province_list'] = $province_list['data'];
		if(isset($areaList['data'])){
			$data['area_list'] = $areaList;
		}
		$this->load->view('add_facility',$data);
	}
	
	public function insertFacilityData() {
		$data = array(
			"facility_name" => $this->input->post("facility_name"),
			"facility_type" => $this->input->post("facility_type"),
			"enabled" => $this->input->post("enabled"),
			"is_self_template" => $this->input->post("is_self_template"),
			"purchase1_time" => $this->input->post("purchase1_time"),
			"purchase2_time" => $this->input->post("purchase2_time"),
			"production1_time" => $this->input->post("production1_time"),
			"production2_time" => $this->input->post("production2_time"),
			"begin_time" => $this->input->post("begin_time"),
			"end_time" => $this->input->post("end_time"),
			"stocktake_deadline" => $this->input->post("stocktake_deadline"),
			"facility_address" => $this->input->post("facility_address"),
			"province_name" => $this->input->post("province_name"),
			"city_name" => $this->input->post("city_name"),
			"district_name" => $this->input->post("district_name"),
			"real_address" => $this->input->post("real_address"),
			"postcode" => $this->input->post("postcode"),
			"schedule_mode" => $this->input->post("schedule_mode"),
			"area_id"=>$this->input->post("area_id"),
			"city_id"=>$this->input->post("city_id")
		);
		$info = $this->facility->addFacility($data);
		echo json_encode($info);
	}
	
	public function getProductList()	{
		$merchant_id = $this->getInput('merchant_id');
		$data = $this->Productmodel->getProductListByMerchantProductName($merchant_id);
		echo  json_encode($data);
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