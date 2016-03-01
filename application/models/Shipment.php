<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Shipment extends CI_Model {

    private $CI  ;
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
   
  public function validateShipmentCanPrint($tracking_number){
  	    $in_data = array("tracking_number"=>$tracking_number);
		$out = $this->helper->get ( "/shipment/validatePrint",$in_data);
		return $out;
//		var_dump($out);
//		$result = array ();
//		if ($this->helper->isRestOk ( $out )) {
//			$result = $out;
//		} else {
//			$result ['error_info'] = $out ['error_info'];
//		}
//		return $result;
  }
   /**
   *  按查询条件取得订单列表 
   *   每个订单中 包含多个商品 
   * @param  [type] $cond   [查询条件数组]
   * @param  [type] $offset [分页中 第 $offset 条记录 ]
   * @param  [type] $limit  [分页中 每页大小 ]
   * @return [type]         [description]
   */
  public function getShipmentPrintData($shipment_id) {
		$out = $this->helper->get ( "/shipment/{$shipment_id}/getPrintData",array());

		$result = array ();
		if ($this->helper->isRestOk ( $out )) {
			$result = $out;
		} else {
			$result ['error_info'] = $out ['error_info'];
		}
		return $result;
  }		
  
  public function printShipment($shipment_id){
	$out = $this->helper->get ( "/shipment/{$shipment_id}/printShipment",array());

	$result = array ();
	if ($this->helper->isRestOk ( $out )) {
		$result = $out;
	} else {
		$result ['error_info'] = $out ['error_info'];
	}
	return $result;
  }
  public function shipShipment($tracking_number){
  	 $in_data = array("tracking_number"=>$tracking_number);
  	 $out = $this->helper->get ( "/shipment/ship",$in_data);
  	 $result = array ();
	if ($this->helper->isRestOk ( $out )) {
		$out['status']='ok';
		$result = $out;
	} else {
		$out['status']='error';
		$result ['error_info'] = $out ['error_info'];
	}
	return $result;
  }
  public function shipShipmentWithWeight($tracking_number,$weight){
  	 $in_data = array("tracking_number"=>$tracking_number,"weight"=>$weight);
  	 $out = $this->helper->get ( "/shipment/weight",$in_data);
  	 $result = array ();
	if ($this->helper->isRestOk ( $out )) {
		$out['status']='ok';
		$result = $out;
	} else {
		$out['status']='error';
		$result ['error_info'] = $out ['error_info'];
	}
	return $result;
  }
  

  
  public function getShipmentList($cond,$offset,$limit){
    if(empty($cond)){
      $cond = array(); 
    }
    $cond['offset'] = $offset;
    $cond['size'] = $limit; 
    $out =  $this->helper->get("/shipment",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  public function getGroupShipmentList($cond){
  	$out = $this->helper->get("/colocated/groupShipmentList/".$cond['facility_id']);
  	if($this->helper->isRestOk($out,"shipment_list")){
    	$result = $out['shipment_list'];
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result;
  }
  public function getShipments($cond){
  	if(empty($cond)){
      $cond = array(); 
    }
    $out =  $this->helper->get("/shipment/list",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
   public function getWmsLogInfo($out_order_sn){
  	if(empty($cond)){
      $cond = array(); 
    }
    $out =  $this->helper->get("/shipment/".$out_order_sn."/wmsloginfo"); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  public function getShipmentDetail($out_order_sn){
  	if(empty($cond)){
      $cond = array(); 
    }
    $out =  $this->helper->get("/shipment/".$out_order_sn."/detail"); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
}

  
