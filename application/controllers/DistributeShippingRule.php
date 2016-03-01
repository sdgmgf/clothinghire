<?php

class DistributeShippingRule extends CI_Controller {
	function __construct(){
		parent::__construct();
	  	$this->load->library('session');
		$this->load->model('common');
		$this->load->model('coverage');
	}
	
	public function index() {
		$input = array();
		$out = $this->coverage->getFacilityCoverage($input);
		$data = $this->helper->merge($out);
		$this->load->view('facility_coverage',$data);
	}
	public function avaible(){
		$facility_id = $this->getInput('facility_id');
		$shipping_id = $this->getInput('shipping_id');
		$input = array('facility_id' => $facility_id,'shipping_id' => $shipping_id);
		$out = $this->coverage->getFacilityAvaiableCoverage($input);
		echo json_encode($out['list'][$facility_id]['shippings'][$shipping_id]);
	}
	
	public function add(){
		$facility_id =  $this->getInput("facility_id");
		$shipping_id = $this->getInput("shipping_id");
		$data = array();
		$temp = $this->input->post("district_ids");
		if(is_array($temp) && count($temp)>0){
			$data['district_ids'] = implode(',',$temp);
		}

		
		$info = $this->coverage->addFacilityCoverage($facility_id,$shipping_id,$data);
		echo json_encode($info);
	}
	public function getFacilityCoverageRegion(){
		$facility_id =  $this->getInput("facility_id");
		$parent_region_id = $this->getInput("parent_region_id");
		$region_type = $this->getInput("region_type");
		if($region_type == '2'){
			$info = $this->coverage->getFacilityCoverageCitys($facility_id,$parent_region_id);
		}else if($region_type == '3'){
			$info = $this->coverage->getFacilityCoverageDistricts($facility_id,$parent_region_id);
		}else{
			$info = array("success"=>"false","error_info"=>'region type in （2,3）');
		}
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