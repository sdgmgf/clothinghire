<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理订单相关的逻辑 为 订单控制器服务 
class Facility extends CI_Model {

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
     
     public function addFacility($data) {
     		$out = $this->helper->post("/facility/addFacility",$data);
     		if($this->helper->isRestOk($out)) {
     			$info['success'] = "OK";
     		}else {
	     		if (isset($out['error_info'])) {
	     			$info['error_info'] = "仓库添加失败！" . $out['error_info'];
	     		} else {
	     			$info['error_info'] = "仓库添加失败！无详细信息";
	     		}
     			$info['error_info'] = "仓库添加失败！";
     		}
     		return $info;
     }
     
     public function getFacilityInfoList() {
     	$out = $this->helper->get("/facility/getFacilityInfoList",array());
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getFacilityDetail($facility_id) {
     	$out = $this->helper->get("/facility/getFacilityDetail",array("facility_id" => $facility_id));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function updateFacility($data){
     	$out = $this->helper->post("/facility/updateFacility",$data);
     	if($this->helper->isRestOk($out)){
     		$info['success'] = "OK";
     	}else{
     		if (isset($out['error_info'])) {
     			$info['error_info'] = "仓库信息修改失败！" . $out['error_info'];
     		} else {
     			$info['error_info'] = "仓库信息修改失败！无详细信息";
     		}
     	}
     	return $info;
     }
     
     public function getShipping($facility_id) {
        $out = $this->helper->get("/facility/getShipping",array("facility_id" => $facility_id));    
        return $out;
     }

     public function getFacilityShippingCoverageArea($facility_id,$shipping_id) {
        $out = $this->helper->get("/facility/".$facility_id."/shipping/".$shipping_id."/getFacilityShippingCoverageArea",array());
        return $out;
     }

     public function addFacilityShippingCoverageArea($facility_id,$shipping_id,$data) {
     	$out = $this->helper->post("/facility/".$facility_id."/shipping/".$shipping_id."/addFacilityShippingCoverageArea",$data);
     	return $out;
     }
     
     public function addFacilityShipping($data) {
		$out = $this->helper->post("/facility/addFacilityShipping",$data);
		if($this->helper->isRestOk($out)) {
			$info['success'] = "OK";
		}else {
     		if (isset($out['error_info'])) {
     			$info['error_info'] = "快递方式添加失败！" . $out['error_info'];
     		} else {
     			$info['error_info'] = "快递方式添加失败！无详细信息";
     		}
		}
		return $info;
     }
     
     public function closeFacilityShipping($facility_shipping_id) {
     	$out = $this->helper->post("/facility/closeFacilityShipping",array("facility_shipping_id" => $facility_shipping_id));
     	if($this->helper->isRestOk($out)) {
     		$info['success'] = "OK";
     	}else {
     		if (isset($out['error_info'])) {
     			$info['error_info'] = "快递方式关闭失败！" . $out['error_info'];
     		} else {
     			$info['error_info'] = "快递方式关闭失败！无详细信息";
     		}
     	}
     	return $info;
     }
     
     public function enableFacilityShipping($facility_shipping_id) {
     	$out = $this->helper->post("/facility/enableFacilityShipping",array("facility_shipping_id" => $facility_shipping_id));
     	if($this->helper->isRestOk($out)) {
     		$info['success'] = "OK";
     	}else {
     		if (isset($out['error_info'])) {
     			$info['error_info'] = "快递方式启用失败！" . $out['error_info'];
     		} else {
     			$info['error_info'] = "快递方式启用失败！无详细信息";
     		}
     	}
     	return $info;
     }
     

     


     

     
     public function getAvaiableProduct($facility_id){
     	$out = $this->helper->get("/facility/".$facility_id."/getAvaiableProduct",array());
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     public function getProductRegionShipping($facility_id){
    	$out = $this->helper->get('/facility/'.$facility_id.'/getProductRegionShipping',array());
    	if($this->helper->isRestOk($out)){
    		return $out;
    	}
    	return null;
    }
    public function getRegionShippings($param){
    	$out = $this->helper->get('/admin/facility/getRegionShipping',$param);
    	if($this->helper->isRestOk($out)){
    		return $out;
    	}
    	return null;
    }
    public function modifyRegionShipping($data){
    	$out = $this->helper->post("/admin/facility/modifyRegionShipping",$data);
    	if($this->helper->isRestOk($out)) {
    		echo json_encode(array("success"=>"true"));
    	}else{
    		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
    	}
    }
    public function deleteRegionShipping($sku_region_shipping_id){
    	$out = $this->helper->post("/admin/facility/deleteRegionShipping/".$sku_region_shipping_id);
    	if($this->helper->isRestOk($out)) {
    		echo json_encode(array("success"=>"true"));
    	}else{
    		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
    	}
    }
    public function getProductShippings($facility_id){
    	$out = $this->helper->get("/admin/getProductShipping/".$facility_id);
    	if($this->helper->isRestOk($out)) {
    		return $out['list'];
    	}
    	return null;
    }
    
    public function addSkuShipping($data){
    	$out = $this->helper->post("/admin/facility/addSkuShipping",$data);

    	if($this->helper->isRestOk($out)) {
    		echo json_encode(array("success"=>"true"));
    	}else{
    		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
    	}
    }
    
    
    public function getProductRegionWithoutShipping($facility_id){
    	$param = array('facility_id'=>$facility_id);
    	$out = $this->helper->get('/admin/facility/noProductRegionShipping', $param);
    	if($this->helper->isRestOk($out)){
    		return $out;
    	}
    	return null;
    }

     public function getAllFacility() {
     	$out = $this->helper->get("/facility/getAllFacility",array());
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function searchProduct($data) {
     	$out = $this->helper->get("/shipment/canTransferList",$data);
     	if($this->helper->isRestOk($out)){
     		$result['success'] = "OK";
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function transfer($data) {
     	$out = $this->helper->post("/shipment/transfer",$data);
     	if($this->helper->isRestOk($out)) {
     		$info = $out;
     	}else {
     		if (isset($out['error_info'])) {
     			$info['error_info'] = $out['error_info'];
     		} else {
     			$info['error_info'] = "转仓失败！ 无详细信息";
     		}
     	}
     	return $info;
     }
     public function getTransferList($params) {
     	$out = $this->helper->get("/shipment/transferList",$params);
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getTransferItems($transfer_shipment_id) {
     	$out = $this->helper->get("/shipment/transferItems",array("transfer_shipment_id" => $transfer_shipment_id));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getFacilityShippingById($data) {
     	$out = $this->helper->get("/facility/getFacilityShipping",$data);
     	if($this->helper->isRestOk($out)) {
     		return $out['record'];
     	}
     	return null;
     }
     
     public function getFacilityByFacilityId($facility_id){
     	$out = $this->helper->get("/facility/getFacilityById/".$facility_id);
     	if($this->helper->isRestOk($out)) {
     		return $out['record'];
     	}
     	return null;
     }
     
     public function getAreaByFacility($facility_id){
     	$out = $this->helper->get("/facility/".$facility_id."/area");
     	if($this->helper->isRestOk($out)) {
     		return $out['shop_area'];
     	}
     	return null;
     }
     
     public function getAreaPurchaseManagerList($params) {
     	return $this->helper->get("/admin/area/purchaseManagerList",$params);
     }
     
     public function getFacilityList($params) {
     	return $this->helper->get("/admin/allfacilities", $params);
     }

     public function getShippingListByCoverage($facility_id,$province_id) {
     	$out = $this->helper->get("/coverage/".$facility_id."/getShippingListByCoverage",array("province_id"=>$province_id));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     public function getFacilityListByShippingRule($product_id,$province_id) {
     	$out = $this->helper->get("/distributionshipping/".$product_id."/getFacilityListByShippingRule",array("province_id"=>$province_id));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
}