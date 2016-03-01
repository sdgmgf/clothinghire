<?php

class FacilityInCityCoverage extends CI_Controller {
	function __construct(){
		parent::__construct();
	  	$this->load->library('session');
		$this->load->model('common');
		$this->load->model('coverage');
	}
	
	public function index() {
		$data = $this->helper->merge(array());
		$this->load->view('facility_in_city_coverage',$data);
	}
	public function getFacilityInCityCoverage(){
		$input = array();
		$out = $this->coverage->getFacilityInCityCoverage($input);
		echo json_encode($out);
	}
	public function availble(){
		$facility_id = $this->getInput('facility_id');
		$shipping_id = $this->getInput('shipping_id');
		$out = $this->coverage->getFacilityInCityAvaiableCoverage($facility_id,$shipping_id,array());
		echo json_encode($out);
	}
	
	public function add(){
		$facility_id =  $this->getInput("facility_id");
		$shipping_id = $this->getInput("shipping_id");
		$data = array();
		$data['district_ids'] = '';
		$temp = $this->input->post("district_ids");
		if(is_array($temp) && count($temp)>0){
			$data['district_ids'] = implode(',',$temp);
		}
		$info = $this->coverage->addFacilityInCityCoverage($facility_id,$shipping_id,$data);
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