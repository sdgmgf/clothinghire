<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class AsnFinish extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model("purchase");
	    $this->helper->chechActionList(array('asnFinish'),true);
	}

	private function getQueryCondition( ){
		$cond = array( );
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		} 
		
		$asn_date = $this->getInput('asn_date');
		if(isset($asn_date)){
			$cond['asn_date'] = $asn_date;
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
	
	public function index() {
		$this->helper->chechActionList(array('caigouManager'),true);
		$this->showIndex('goods');
	}

	public function suppliesIndex() {
		$this->helper->chechActionList(array('suppliesCaigouManager'),true);
		$this->showIndex('supplies');
	}
	private function showIndex( $product_type ) {
		$cond = $this->getQueryCondition();
		$facility_list = $this->common->getFacilityList();
		if(empty($facility_list)) {
			die('无仓库权限');
		}
		$cond['facility_list'] = $facility_list['data'];
		if(empty($cond['facility_id'])) {
			$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
			$cond['facility_type'] = $facility_list['data'][0]['facility_type'];
			$cond['area_type'] = $facility_list['data'][0]['area_type'];
		}else{
			foreach ($cond['facility_list'] as $key => $val) {
				if( $cond['facility_id'] === $val['facility_id'] ){
					$cond['facility_type'] = $val['facility_type'];
					$cond['area_type'] = $val['area_type'];
					break;
				}
			}
		}
		$cond['product_type'] = $product_type;
		if(empty($cond['asn_date'])) {
			$cond['asn_date'] = date('Y-m-d');
		}
		$asn = $this->purchase->getAsn( $cond['facility_id'], $cond['asn_date'], $cond['product_type'],$cond['facility_type'], $cond['area_type'] );
		if( !is_array( $asn ) ) {
			echo isset($asn)?$asn:"ERROR!请联系ERP";
			$data = $this->helper->merge($cond);
			$this->load->view('asn_finish', $data);
			return;
		}else{
			$asn = $asn[0];
		}
		$asnItemList = $this->purchase->getAsnItemList($asn['asn_id']);
		
		if(!isset($asnItemList)) {
			$cond['asn_id'] = $asn['asn_id'];
			$data = $this->helper->merge($cond);
			$this->load->view('asn_finish', $data);
			return;
		}
		$cond['asn_item_list'] = $asnItemList;
		$cond['asn_id'] = $asn['asn_id'];
		$data = $this->helper->merge($cond);
		$this->load->view('asn_finish', $data);
	}
}
?>