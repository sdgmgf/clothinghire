<?php

class AbnormalShipment extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('Helper');
	}

	public function index() {
		$cond = array();
		$data = $this->helper->merge($cond);
		$this->load->view('abnormal_shipment',$data);
	}

	public function getShopFileUnset(){
		$cond = array();
		
	    $abnormal_shipment_type = $this->input->get("abnormal_shipment_type");
	    if(isset($abnormal_shipment_type)){
	    	$cond['abnormal_shipment_type'] = $abnormal_shipment_type;
	    } else{
	    	$cond['abnormal_shipment_type'] = '';
	    }
	    $out = $this->helper->get("/shipment/getAbnormalShipment",$cond);
	    echo json_encode($out);
	}

	public function getCommodityFileUnset(){
		$cond = array();
		
	    $abnormal_shipment_type = $this->input->get("abnormal_shipment_type");
	    if(isset($abnormal_shipment_type)){
	    	$cond['abnormal_shipment_type'] = $abnormal_shipment_type;
	    } else{
	    	$cond['abnormal_shipment_type'] = '';
	    }
	    $out = $this->helper->get("/shipment/getAbnormalShipment",$cond);
	    echo json_encode($out);
	}

	public function getFacilityUnselect(){
		$cond = array();
		
	    $abnormal_shipment_type = $this->input->get("abnormal_shipment_type");
	    if(isset($abnormal_shipment_type)){
	    	$cond['abnormal_shipment_type'] = $abnormal_shipment_type;
	    } else{
	    	$cond['abnormal_shipment_type'] = '';
	    }
	    $out = $this->helper->get("/shipment/getAbnormalShipment",$cond);
	    echo json_encode($out);
	}

	public function getShippingUnselect(){
		$cond = array();
		
	    $abnormal_shipment_type = $this->input->get("abnormal_shipment_type");
	    if(isset($abnormal_shipment_type)){
	    	$cond['abnormal_shipment_type'] = $abnormal_shipment_type;
	    } else{
	    	$cond['abnormal_shipment_type'] = '';
	    }
	    $out = $this->helper->get("/shipment/getAbnormalShipment",$cond);
	    echo json_encode($out);
	} 
	public function getDetail() {
		$cond = array();
		$abnormal_shipment_type = $this->input->get("abnormal_shipment_type");
	    if(isset($abnormal_shipment_type)){
	    	$cond['abnormal_shipment_type'] = $abnormal_shipment_type;
	    } 
	    $shop_id = $this->input->get("shop_id");
	    if(isset($shop_id)){
	    	$cond['shop_id'] = $shop_id;
	    } 
	    $goods_id = $this->input->get("goods_id");
	    if(isset($goods_id)){
	    	$cond['goods_id'] = $goods_id;
	    } 
	    $product_id = $this->input->get("product_id");
	    if(isset($product_id)){
	    	$cond['product_id'] = $product_id;
	    } 
	    $city_id = $this->input->get("city_id");
	    if(isset($city_id)){
	    	$cond['city_id'] = $city_id;
	    } 
	    $facility_id = $this->input->get("facility_id");
	    if(isset($facility_id)){
	    	$cond['facility_id'] = $facility_id;
	    } 
	    $district_id = $this->input->get("district_id");
	    if(isset($district_id)){
	    	$cond['district_id'] = $district_id;
	    } 
		$data = $this->helper->merge($cond);
		$this->load->view('abnormal_shipment_detail',$data);
	}
	public function getDetailData(){
		$cond = array();
		$abnormal_shipment_type = $this->input->get("abnormal_shipment_type");
	    if(isset($abnormal_shipment_type)){
	    	$cond['abnormal_shipment_type'] = $abnormal_shipment_type;
	    } 
	    $shop_id = $this->input->get("shop_id");
	    if(isset($shop_id)){
	    	$cond['shop_id'] = $shop_id;
	    } 
	    $goods_id = $this->input->get("goods_id");
	    if(isset($goods_id)){
	    	$cond['goods_id'] = $goods_id;
	    } 
	    $product_id = $this->input->get("product_id");
	    if(isset($product_id)){
	    	$cond['product_id'] = $product_id;
	    } 
	    $city_id = $this->input->get("city_id");
	    if(isset($city_id)){
	    	$cond['city_id'] = $city_id;
	    } 
	    $facility_id = $this->input->get("facility_id");
	    if(isset($facility_id)){
	    	$cond['facility_id'] = $facility_id;
	    } 
	    $district_id = $this->input->get("district_id");
	    if(isset($district_id)){
	    	$cond['district_id'] = $district_id;
	    } 

	    $out = $this->helper->get("/shipment/getAbnormalShipmentDetail",$cond);
	    echo json_encode($out);
	}
    
    public function checkStationParams($city_name,$station,$station_no){
        if(empty($city_name) || empty($station) || empty($station_no)){
            $cond = array();
            $data = $this->helper->merge($cond);
            $this->load->view('abnormal_shipment',$data);
        } else{
            return true;
        }
    }

}
?>
