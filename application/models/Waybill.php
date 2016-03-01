<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Waybill extends CI_Model {

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
   
  public function getToWaybillList($cond){
  	if(empty($cond)){
      $cond = array(); 
    }
    $out =  $this->helper->get("/admin/waybills/showUnWaybillList",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  public function createWaybill($cond){
  	if(empty($cond)){
      $cond = array(); 
    }
    $out =  $this->helper->post("/admin/waybills",$cond); 
//    $result = array();  
    if($this->helper->isRestOk($out)){
//    	$result = "生成发运单成功";
		$result = $out;	
    }else{
    	$result['result'] = 'fail';
    	$result['error_info'] = "生成发运单失败";
    }
    return $result; 
  }
  public function getWaybillList($cond,$offset,$limit){
    if(empty($cond)){
      $cond = array(); 
    }
    $cond['offset'] = $offset;
    $cond['size'] = $limit; 
    $out =  $this->helper->get("/admin/waybills",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
}

  