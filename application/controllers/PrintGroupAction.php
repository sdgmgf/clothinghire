<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PrintGroupAction extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  $this->load->library('session'); 
    $this->load->library('Pager'); 
    $this->load->library('Helper'); 
    $this->load->model('order');
	}

  public function index()
  {
  	
	error_reporting(E_ALL ^ E_NOTICE);
	$sinri_plus = array();
	
	$order = array(
		"batch_sn" => $this->getInput('batch_sn'),
		"facility_name" => $this->getInput('facility_name'),
		"secrect_code" => $this->getInput('secrect_code'),
		"rg_info" => $this->getInput('rg_info'),
		"rg_total" => $this->getInput('rg_total'),
		"goods_number" => $this->getInput('goods_number'),
		"mobile" => $this->getInput('mobile'),
		"tracking_number" => $this->getInput('tracking_number'),
		"consignee" => $this->getInput('consignee'),
		"batch_items" => json_decode(urldecode($this->getInput('batch_items')), true),
	);
	
	$cond['order'] = $order;
	$cond['tracking_number'] = $this->helper->getUrl() . "codeImg?barcode="  . $order['tracking_number'] . "&height=80&width=500&text=0";
	$data = $this->helper->merge($cond); 
	$this->load->view('batch_group_print',$data);
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
