<?php
class Stocktakepackage extends CI_Model {

	private $CI;
	private $helper;
	function __construct(){
		parent::__construct();
		if(!isset($this->CI)){
			$this->CI = & get_instance();
		}
		if(!isset($this->helper)){
			$this->CI->load->library('Helper');
			$this->helper = $this->CI->helper;
		}
	}
	
	public function getStocktakePackageProductList($cond) {
		$out =  $this->helper->get("/admin/stocktake_package_product_list", $cond);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out;
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}
	
	public function createStocktakePackage($cond) {
		$out =  $this->helper->post("/admin/create_stocktake_package", $cond);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out;
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}
	
	public function getStocktakePackageList($cond) {
		$out =  $this->helper->get("/admin/stocktake_package_list", $cond);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out;
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}
	
	public function executeStocktakePackage($cond) {
		$out =  $this->helper->post("/admin/execute_stocktake_package", $cond);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out;
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}
	
	public function checkStocktakePackage($cond) {
		$out =  $this->helper->post("/admin/check_stocktake_package", $cond);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out;
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}
}
?>