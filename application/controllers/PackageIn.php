<?php
class PackageIn extends CI_Controller {
	function __construct() {
		date_default_timezone_set("Asia/Shanghai");
		parent::__construct();
		$this->load->model('common');
		$this->load->model('productmodel');
		$this->load->model('facility');
		$this->load->model('inventorytransaction');
	}
	
	public function index() {
		$cond = array();
    	$facility_list = $this->common->getFacilityList();
    	$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
    	$cond['facility_list'] = $facility_list['data'];
     	$out = $this->productmodel->getFinishedProductListByFacilityID($cond['facility_id']);
    	$data = array_merge($cond,$out);
    	$data = $this->helper->merge($data);
    	$this->load->view("package_in",$data);
	}
	
	public function createPackageInTransaction(){
		$cond = array();
    	$cond['facility_id'] = $this->input->post("hidden_facility_id");
    	$cond['note'] = $this->input->post("hidden_note");
    	$cond['product_id'] = $this->input->post("product_id");
    	$cond['quantity'] = $this->input->post("quantity");

    	
    	if (empty ($cond['product_id']) || empty($cond['quantity'])) {
    		echo "请输入数量";
    		die();
    	}
    	$out = $this->inventorytransaction->createPackageInTransaction($cond);
    	if (isset($out['error_info'])) {
    		echo json_encode(array("error_info" => "入库失败：" . $out['error_info']));
    	} else {
    		echo json_encode(array("success" => 'success'));
    	}
	}
}
?>
