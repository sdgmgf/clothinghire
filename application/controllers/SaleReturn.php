<?php

// 销售出库
class SaleReturn extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('inventorytransaction');
      $this->load->model('common');
      $this->load->model('productmodel');
      $this->helper->chechActionList(array('saleReturn'),true);
	
    }
    
    public function index() {
    	$cond = array();
    	$facility_list = $this->common->getFacilityList();
    	$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
    	$cond['product_type'] = $this->getInput('product_type');
        if ($cond['product_type'] == 'supplies' && !$this->helper->chechActionList(array('suppliesInventoryManager'))) {
        	die("无耗材权限");
        }
        if ($cond['product_type'] != 'supplies' && !$this->helper->chechActionList(array('wuliaoManager'))) {
        	die("无商品权限");
        }
    	
        $out = $this->inventorytransaction->getCanSaleReturnProductList($cond);
        if (isset($out['error_info'])) {
        	var_dump($out['error_info']);
        	die("错误");
        } else {
        	$cond['product_list'] = $out['data']['product_list'];
        }
        
        $cond['facility_list'] = $facility_list['data'];
        $data = $this->helper->merge($cond); 
        $this->load->view('sale_return',$data);
    }
    
    public function getProductContainer(){
    	$cond = array();
    	$cond['container_code'] = $this->getInput('container_code');
    	$out = $this->productmodel->getProductContainer($cond);
    	if (! isset($out) || empty($out)) {
    		echo "null";
    	} else {
    		echo json_encode($out[0]);
    	}
    }
    
    public function createSaleReturnTransaction() {
    	$cond = array();
    	$cond['facility_id'] = $this->input->post("hidden_facility_id");
    	$cond['container_code'] = $this->input->post("container_code");
    	$cond['real_quantity'] = $this->input->post("real_quantity");


    	
    	if (empty ($cond['container_code']) || empty($cond['real_quantity'])) {
    		echo "请输入数量";
    		die();
    	}
    	
    	
    	$out = $this->inventorytransaction->createSaleReturnTransaction($cond);

    	if (isset($out['error_info'])) {
    		echo json_encode(array("error_info" => "入库失败：" . $out['error_info']));
    	} else {
    		echo json_encode(array("success" => 'success'));
    	}
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
}
?>
