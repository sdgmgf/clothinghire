<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class Shipments extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('shipment');
	    $this->load->model('region');
	    $this->load->library('Excel');
	    $this->load->model('common');
	    $this->helper->chechActionList(array('orderList'),true);
	}
  public function index($cond = array()){
  	// $cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端
    $cond = $this->helper->merge($cond); 
    $this->load->view('shipment_list',$cond);
  }
  public function showList($cond = array())
  {
  	$cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端
  	$cond['offset'] = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
  	$cond['size'] = $cond['page_limit'];

  	$info = $this->shipment->getShipments($cond);
    $info['iTotalRecords'] = $info['total'];
    $info['iTotalDisplayRecords'] = $info['total'];
  	echo json_encode($info);
  }
  
  public function showDetail($cond = array()){
    $cond = $this->helper->merge($cond);
    $shipment_id = $this->getInput('shipment_id');
    if(isset($shipment_id)){
      $cond['shipment_id'] = $shipment_id;
    }
    $this->load->view('shipment_detail',$cond);
  }
  public function getWmsLogInfo(){
    $out_order_sn = $this->getInput('out_order_sn');
    $info = $this->shipment->getWmsLogInfo($out_order_sn);
    if(isset($info['data']['fetch_log']['format_route_info'])){
        $info['data']['fetch_log']['format_route_info'] = json_decode($info['data']['fetch_log']['format_route_info'],true);
    }
    echo json_encode($info);
  }  
  private function get_data($url,$data){
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $ret = curl_exec ( $ch );
    curl_close ( $ch );
    //  var_dump($ret);
    return $ret;
  }
  public function getDetail(){
    $out_order_sn = $this->getInput('out_order_sn');
    $info = $this->shipment->getShipmentDetail($out_order_sn);
    $info = $this->helper->merge($info);
    echo json_encode($info);
  }
// 获取前端 post 传递过来的查询条件
  private function getQueryCondition( ){
  	$cond = array( );
  	
  	$area_id = $this->getInput('area_id');
  	if(isset($area_id)) {
  		$cond['area_id'] = $area_id;
  	}
  	
  	$facility_id = $this->getInput('facility_id');
  	if(isset($facility_id)) {
  		$cond['facility_id'] = $facility_id;
  	}
  	
  	$shipping_id = $this->getInput('shipping_id');
  	if(isset($shipping_id)) {
  		$cond['shipping_id'] = $shipping_id;
  	}
  	
  	$tracking_number = $this->getInput('tracking_number');
  	if(isset($tracking_number)) {
  		$cond['tracking_number'] = trim($tracking_number);
  	}
  	
  	$order_sn = $this->getInput('order_sn');
  	if(isset($order_sn)) {
  		$cond['out_order_sn'] = trim($order_sn);
  	}
    $page_limit = $this->getInput('length');

    if(empty($page_limit)) {
      $page_limit = 50;
    }
    $cond['page_limit'] = $page_limit;

    $start = $this->getInput('start');
  	$page_current = $start/$page_limit + 1;
  	if(!empty($page_current)) {
  		$cond['page_current'] = $page_current;
  	}else{
  		$cond['page_current'] = 1;
  	}
  	
  
  	return $cond;
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