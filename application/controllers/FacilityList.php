<?php

class FacilityList extends CI_Controller {
	function __construct(){
		parent::__construct();
	  	$this->load->library('session');
		$this->load->model('common');
		$this->load->model('facility');
		$this->load->model('region');
		$this->load->model('shipping_template_model');
	}
	
	public function index() {
		$out = $this->facility->getFacilityInfoList();
		$data['facility_info_list'] = $out['data']['facility_info_list'];
		foreach($data['facility_info_list'] as &$record){
			if($record['schedule_mode'] == 'manual_schedule_manual_shipping'){
				$record['schedule_mode_desc'] = "纯手动分配发送"; 
			}elseif($record['schedule_mode'] == 'manual_schedule_auto_shipping'){
				$record['schedule_mode_desc'] = '手动分配自动发送';
			}elseif($record['schedule_mode'] == 'auto_schedule_auto_shipping'){
				$record['schedule_mode_desc'] = '全自动分配发送';
			}else{
				$record['schedule_mode_desc'] = $record['schedule_mode'];
			}
		}
		$data = $this->helper->merge($data);
		$this->load->view('facility_list',$data);
	}
	
	public function detail() {
		//获取仓库详情信息
		$facility_id = $this->getInput('facility_id');
		$out = $this->facility->getFacilityDetail($facility_id);
		$data = $out['data'];
		$data = $this->helper->merge($data);
		$this->load->view('facility_detail',$data);
	}
	
	public function updateFacility(){
		$data = array(
				"facility_id" => $this->input->post("facility_id"),
				"facility_name" => $this->input->post("facility_name"),
				"facility_type" => $this->input->post("facility_type"),
				"enabled" => $this->input->post("enabled"),
				"is_self_template" => $this->input->post("is_self_template"),
				"facility_address" => $this->input->post("facility_address"),
				"province_name" => $this->input->post("province_name"),
				"city_name" => $this->input->post("city_name"),
				"district_name" => $this->input->post("district_name"),
				"real_address" => $this->input->post("real_address"),
				"postcode" => $this->input->post("postcode"),
				"schedule_mode" => $this->input->post("schedule_mode"),
			"attribute_info" => array(
				"purchase_plan1_time" => $this->input->post("purchase1_time"),
				"purchase_plan2_time" => $this->input->post("purchase2_time"),
				"production_plan1_time" => $this->input->post("production1_time"),
				"production_plan2_time" => $this->input->post("production2_time"),
				"fulfill_start_time" => $this->input->post("begin_time"),
				"fulfill_end_time" => $this->input->post("end_time"),
				"stocktake_deadline" => $this->input->post("stocktake_deadline")
			)
		);
		$info = $this->facility->updateFacility($data);
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