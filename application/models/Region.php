<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Region extends CI_Model {

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
   *  按查询条件取得订单列表 
   *   每个订单中 包含多个商品 
   * @param  [type] $cond   [查询条件数组]
   * @param  [type] $offset [分页中 第 $offset 条记录 ]
   * @param  [type] $limit  [分页中 每页大小 ]
   * @return [type]         [description]
   */
  public function getRegion($parent_id, $region_type){
    $cond = array(); 
    if ($parent_id) $cond['parent_id'] = $parent_id;
    if ($region_type) $cond['region_type'] = $region_type;
    
    $out =  $this->helper->get("/regions",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  public function getCitys($province_ids) {
  	$cond = array();
  	if(empty($province_ids)) {
  		return null;
  	}
  	$out =  $this->helper->get("/regions/getCitys/".$province_ids);
  	$result = array();
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out;
  	}else{
  		$result['error_info'] = $out['error_info'];
  	}
  	return $result;
  }
  
  public function getStationList($facility_id,$shipping_id) {
  	if(empty($facility_id)){
  		return null;
  	}
  	$out = $this->helper->get("/regions/getStationList",array("facility_id" =>$facility_id,"shipping_id"=>$shipping_id));
  	$result = array();
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out;
  	}else{
  		$result['error_info'] = $out['error_info'];
  	}
  	return $result;
  }
}