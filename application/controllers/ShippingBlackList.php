<?php

class ShippingBlackList extends CI_Controller {
    function __construct()
    {
        parent::__construct();
         $this->load->library('Helper');
         $this->load->library('Pager');
         $this->load->model('region');
    }
    
    public function index(){
		$con = array();
    	
		$province_list = $this->region->getRegion(null, 1);
    	$con['province_list'] = isset($province_list['data']) ? $province_list['data'] : array();
	    $city_list = $this->region->getRegion($con['province_list']['regions'][0]['region_id'], 1);
	    $con['city_list'] = isset($city_list['data']) ? $city_list['data'] : array();
	    $district_list = $this->region->getRegion($con['city_list']['regions'][0]['region_id'], 1);
    	$con['district_list'] = isset($district_list['data']) ? $district_list['data'] : array();
    		
    	$lists = $this->helper->get("/admin/shipping/enabled");
    	if( $this->helper->isRestOk($lists,'shipping_list') ){
    		$con['shipping_list'] = $lists['shipping_list'];
    	}else{
    		$con['shipping_list'] = array();
    	}
    	$con['WEB_ROOT'] = $this->helper->getUrl();
    	$data = $this->helper->merge($con);
    	
    	$this->load->view('ship_black_list',$data);
    }
    
    public function addRecord(){
    	$con = array();
    	$con['shipping_id'] = $this->input->post('shipping_id');
    	$con['district_id'] = $this->input->post('district_id');
    	if(!isset($con['shipping_id']) || !isset($con['district_id'])){
    		echo json_encode(array("success"=>"false","error_info"=>'缺少必要信息。'));
    	}
    	$out = $this->helper->post("/shipping/addBlackList/".$con['shipping_id']."/".$con['district_id']);
    	if($this->helper->isRestOk($out)){
    		echo json_encode(array("success"=>"true"));
    	}else{
    		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
    	}
    }
    
    public function deleteRecord(){
    	$con = $this->getQueryCond();
    	if(!isset($con['shipping_id']) || !isset($con['district_id'])){
    		echo json_encode(array("success"=>"false","error_info"=>'缺少必要信息。'));
    	}
    	$out = $this->helper->post("/shipping/blackList/".$con['shipping_id']."/".$con['district_id']);
    	if($this->helper->isRestOk($out)){
    		echo json_encode(array("success"=>"true")); 
    	}else{
    		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
    	}
    }
    
    public function getQueryCond(){
    	$con = array();
    	$con['shipping_id'] = $this->input->get('shipping_id');
    	$con['district_id'] = $this->input->get('district_id');
    	$con['page_current'] = $this->input->get('page_current');
    	if(empty($con['page_current'])) {
    		$con['page_current'] = 1;
    	}
    	$con['page_count'] = $this->input->get('page_count');
    	
    	$con['page_limit'] = $this->input->get('page_limit');
    	if(empty($con['page_limit'])) {
    		$con['page_limit'] = 20;
    	}
    	return $con;
    }
    
    public function queryList(){
    	$con = $this->getQueryCond();
    	$con['offset'] = (intval($con['page_current'])-1)*intval($con['page_limit']);
    	$con['size'] = $con['page_limit'];
    	if(isset($con['shipping_id']) && !empty($con['shipping_id'])){
    		
    		$out = $this->helper->get("/shipping/blackList/".$con['shipping_id'], $con);
    		
	    	$province_list = $this->region->getRegion(null, 1);
    		$con['province_list'] = isset($province_list['data']) ? $province_list['data'] : array();
	    	$city_list = $this->region->getRegion($con['province_list']['regions'][0]['region_id'], 1);
	    	$con['city_list'] = isset($city_list['data']) ? $city_list['data'] : array();
	    	$district_list = $this->region->getRegion($con['city_list']['regions'][0]['region_id'], 1);
    		$con['district_list'] = isset($district_list['data']) ? $district_list['data'] : array();
    		
    		$list = array();
	    	
	    	if( $this->helper->isRestOk($out,'black_list') ){
	    		$list = $out['black_list']['list'];
	    		$con['record_total'] = $out['black_list']['total'];
	    		$page_count = $con['page_current']+1;
	    		if( count($list) < $con['size'] ){
	    			$page_count = $con['page_current'];
	    		}
	    		if(!empty($record_total)){
	    			$con['record_total'] = $record_total;
	    			$page_count = ceil($record_total / $con['size'] );
	    		}
	    		$con['page_count'] = $page_count;
	    		$con['page'] = $this->pager->getPagerHtml($con['page_current'],$page_count);
	    	}else{
	    		if(isset($out['error_info'])){
	    			$con['error_info'] = $out['error_info'];
	    		}
	    	}
	    	$con['black_list'] = $list;
    	}
    	
    	$lists = $this->helper->get("/admin/shipping/enabled");
    	if( $this->helper->isRestOk($lists,'shipping_list') ){
    		$con['shipping_list'] = $lists['shipping_list'];
    	}else{
    		$con['shipping_list'] = array();
    	}
    	$con['WEB_ROOT'] = $this->helper->getUrl();
    	$data = $this->helper->merge($con);
    	$this->load->view('ship_black_list',$data);
    }
}