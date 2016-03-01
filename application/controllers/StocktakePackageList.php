<?php

class StocktakePackageList extends CI_Controller {
	function __construct() {
		date_default_timezone_set("Asia/Shanghai");
		parent::__construct();
		$this->load->library('Pager');
		$this->load->model('stocktakepackage');
		$this->load->model('common');
		$this->load->model('productmodel'); 
	}
	public function index(){
        $facility_id = $this->getInput('facility_id');
		$facility_list = $this->common->getFacilityList();
		if (!isset($facility_id)) {
			$facility_id = $facility_list['data'][0]['facility_id'];
		}
		$cond['facility_id'] = $facility_id;
		$product_name = $this->getInput('product_name');
		if (isset($product_name) && $product_name) $cond['product_name'] = trim($product_name);
		$finished_product_list = $this->stocktakepackage->getStocktakePackageProductList($cond);
		$cond['product_list'] = $finished_product_list['data']['product_list'];
		$cond['facility_list'] = $facility_list['data'];
		$data = $this->helper->merge($cond);
		$this->load->view("stocktake_package",$data);
	}
	
	public function createStocktakePackage(){
		$cond = array(
				"facility_id" => $this->getInput("facility_id"),
				"product_id" => $this->getInput("product_id")
		);
		$out = $this->stocktakepackage->createStocktakePackage($cond);
		$data = $out;
		echo json_encode($data);
	}
	
	
	public function query() {
	$cond = $this->getQueryCondition();
		$facility_list = $this->common->getFacilityList();
		if(!isset($cond['facility_id']) && empty($cond['facility_id'])){
			$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
		}
		$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
		$limit = $cond['page_limit'];
		$cond['offset'] = $offset;
		$cond['size'] = $limit;
		$out = $this->stocktakepackage->getStocktakePackageList($cond);
		$stocktake_list =  $out['data']['stocktake_list'] ;
		// 分页
		$record_total = $out['data']['total'];
		$page_count = $cond['page_current']+3;
		if(count($stocktake_list) < $limit ){
			$page_count = $cond['page_current'];
		}
		if(!empty($record_total)){
			$cond['record_total'] = $record_total;
			$page_count = ceil($record_total / $limit );
		}
		$cond['page_count'] = $page_count;
		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
		
		$cond['facility_list'] = $facility_list['data'];
		$data = array_merge($out['data'],$cond);
		$data = $this->helper->merge($data);
		$this->load->view("stocktake_package_list",$data);
	}
	
	//录入
	public function executeStocktakePackage() {
		$cond = array(
				"stocktake_package_id" => $this->getInput("stocktake_package_id"),
				"quantity" => $this->getInput("quantity")
		);
		$out = $this->stocktakepackage->executeStocktakePackage($cond);
		$data = $out;
		echo json_encode($data);
	}
	
	public function checkStocktakePackage() {
		$cond = array(
				"stocktake_package_id" => $this->getInput("stocktake_package_id"),
				"check" => $this->getInput("check"),
				"note" => $this->getInput("note")
		);
		$out = $this->stocktakepackage->checkStocktakePackage($cond);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
		
		
	}
	
	private function getQueryCondition() {
		$cond = array( );
 		$cond['start_time'] = date('Y-m-d 06:00:00');
	
		$start_time =  $this->getInput('start_time');
		if(isset($start_time)) $cond['start_time'] = $start_time;// 时间段起始
		$end_time =  $this->getInput('end_time');// 时间段终止
		if(isset($end_time)) $cond['end_time'] = $end_time;
	
		$product_id =  $this->getInput('product_id');
		if(isset($product_id)) $cond['product_id'] = $product_id;
	
		$product_name =  $this->getInput('product_name');
		if(isset($product_name)) $cond['product_name'] = $product_name;
	
		$facility_id =  $this->getInput('facility_id');
		if(isset($facility_id)) $cond['facility_id'] = $facility_id;
		$status = $this->getInput('status');
		if (isset($status) && $status != "all") $cond['status'] = $status;
	
	
		$page_current = $this->getInput('page_current');
		if(!empty($page_current)) {
			$cond['page_current'] = $page_current;
		}else{
			$cond['page_current'] = 1;
		}
		$page_limit = $this->getInput('page_limit');
		if(!empty($page_limit)) {
			$cond['page_limit'] = $page_limit;
		}else{
			$cond['page_limit'] = 50;
		}
		return $cond;
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name) {
		$out = trim($this->input->post($name));
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}
	
	public function getProductList(){
		$out = array();
		$out = $this->productmodel->getProductList(array());
		if(isset($out)&&isset($out['product_list'])){
			echo json_encode(array('success'=>'success','product_list'=>$out['product_list']));
		}else{
			echo json_encode(array('success'=>'failed'));
		}
	}
}

?>