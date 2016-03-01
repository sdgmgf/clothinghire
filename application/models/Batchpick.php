<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Batchpick extends CI_Model {

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
  /**
   *  按查询条件取得待打单列表
   *   每个订单中 包含多个商品 
   * @param  [type] $cond   [查询条件数组]
   * @param  [type] $offset [分页中 第 $offset 条记录 ]
   * @param  [type] $limit  [分页中 每页大小 ]
   * @return [type]         [description]
   */
  public function getOrderPrintList($cond,$offset,$limit){
    if(empty($cond)){
      $cond = array(); 
    }
    $cond['offset'] = $offset;
    $cond['size'] = $limit; 
    $out =  $this->helper->get("/print/print_orders",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  public function getBatchPrintList($cond,$offset,$limit){
    if(empty($cond)){
      $cond = array(); 
    }
    $cond['offset'] = $offset;
    $cond['size'] = $limit; 
    $out =  $this->helper->get("/print/batch_pick_list",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  public function getBatchPrint($batch_pick_id){
    $out = $this->helper->get("/print/batch_pick"."/".$batch_pick_id);
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  /**
  *  打单
  * @param  [type] $order_id [订单 id 号 ]
  * @return [type]           [description]
  */
 public function printOrder($order_id, $tracking_number = null){
    $out = $this->helper->post("/print/print_orders"."/".$order_id, array("tracking_number"=>$tracking_number));
    $result = array(); 
    if( $this->helper->isRestOk($out) ){
    	$result['data'] = $out['order'];
    }else {
        $result['error_info'] = $out['error_info']; 
    }
    return $result; 
  }
  
  /**
  *  打单
  * @param  [type] $order_id [订单 id 号 ]
  * @return [type]           [description]
  */
 public function printBatchPick($batch_pick_id){
    $out = $this->helper->put("/print/batch_pick"."/".$batch_pick_id."/print");
    $result = array(); 
    if( $this->helper->isRestOk($out) ){
    	$result['data'] = '';
    }else {
        $result['error_info'] = $out['error_info']; 
    }
    return $result; 
  }
  
  public function createBatchPick($product_id,$shipping_id, $facility_id, $shipment_ids){
  	$data = array();
  	$data['product_id'] = $product_id;
  	$data['shipping_id'] = $shipping_id;
  	$data['facility_id'] = $facility_id;
  	$data['shipment_ids'] = $shipment_ids;
  	$out = $this->helper->post("/print/batch_pick", $data);
	$result = array(); 
    if( $this->helper->isRestOk($out) ){
    	$result['data'] = $out;
    }else {
        $result['error_info'] = $out['error_info']; 
    }
    return $result; 
  }
  
  public function getBatchPickInfo ($batch_pick_id) {
  	$out =  $this->helper->get("/print/batch_pick_info/".$batch_pick_id,array());
  	$result = array();
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out;
  	}else{
  		$result['error_info'] = $out['error_info'];
  	}
  	return $result;
  }
  
  public function getBatchPrintBySN($batch_pick_sn){
  	$out = $this->helper->get("/print/batch_pick_info/batchpicksn/".$batch_pick_sn);
  	$result = array();
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out;
  	}else{
  		$result['error_info'] = $out['error_info'];
  	}
  	return $result;
  }
  
  public function validateBatchPickPrinted($batch_pick_sn){
  		$out = $this->helper->get("/print/batch_info/".$batch_pick_sn);
  		$result = '';
  		if($this->helper->isRestOk($out)){
  			if(empty($out['batch_info'])){
  				$result = '无此批次号';
  			} elseif (! $out['batch_info']['can_print']) {
  				$result = '星期五早上六点至星期天早上六点，不许打印工作件批次';
  			} else {
  				$result= $out['batch_info']['status'];
  			}
  		}else{
  			$result = $out['error_info'];
  		}
  		return $result;
  }
}

  