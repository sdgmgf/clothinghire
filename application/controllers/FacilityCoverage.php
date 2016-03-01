<?php

class FacilityCoverage extends CI_Controller {
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

	public function setIgnoreWmsAddress(){
		$facility_id = $this->input->post("facility_id");
	    if(isset($facility_id)){
	    	$cond['facility_id'] = $facility_id;
	    } else{
	    	$cond['facility_id'] = '';
	    }

	    $shipping_id = $this->input->post("shipping_id");
	    if(isset($shipping_id)){
	    	$cond['shipping_id'] = $shipping_id;
	    } else{
	    	$cond['shipping_id'] = '';
	    }

	    $district_id = $this->input->post("district_id");
	    if(isset($district_id)){
	    	$cond['district_id'] = $district_id;
	    } else{
	    	$cond['district_id'] = '';
	    }

	    $ignore_wms_address = $this->input->post("ignore_wms_address");
	    if(isset($ignore_wms_address)){
	    	$cond['ignore_wms_address'] = $ignore_wms_address;
	    } else{
	    	$cond['ignore_wms_address'] = '';
	    }

	    $is_already_set = $this->input->post("is_already_set");
	    if(isset($is_already_set)){
	    	$cond['is_already_set'] = $is_already_set;
	    } else{
	    	$cond['is_already_set'] = '';
	    }

	    $out = $this->helper->post("/coverage/updateFacilityAvaiableCoverage",$cond);
	    echo json_encode($out);
	}
	
	public function add(){
		$facility_id =  $this->getInput("facility_id");
		$shipping_id = $this->getInput("shipping_id");
		$data = array();
		$data['districts'] = $this->input->post("districts");
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