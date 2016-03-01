<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理订单相关的逻辑 为 订单控制器服务 
class Station extends CI_Model {

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

    public function getAvailableCitys() {
     	$out = $this->helper->get("/station/available_citys",array());
     	return $out;
    }
    public function getAvailableShipments($data) {
     	$out = $this->helper->get("/station/available_shipments",$data);
     	return $out;
    }
    public function getStationList($data) {
     	$out = $this->helper->get("/station/station_list",$data);
     	return $out;
    }
    public function getStationInfo($station_id) {
     	$out = $this->helper->get("/station/".$station_id."/station_info",array());
     	return $out;
    }
    public function getStationKeyword($station_id) {
     	$out = $this->helper->get("/station/".$station_id."/station_keyword",array());
     	return $out;
    }
    public function addStationKeyword($station_id,$data) {
     	$out = $this->helper->post("/station/".$station_id."/add_station_keyword",$data);
     	return $out;
    }
    public function deleteStationKeyword($station_id,$data) {
     	$out = $this->helper->post("/station/".$station_id."/del_station_keyword",$data);
     	return $out;
    }
    public function addStation($data) {
        $out = $this->helper->post("/station/add_station",$data);
        return $out;
    }
    public function getAvailableShipping($data){
        $out = $this->helper->get("/admin/shipping/enabled",$data);
        return $out;
    }
    public function getAvailableDistricts($data){
        $out = $this->helper->get("/station/available_districts",$data);
        return $out;
    }
    public function getSubRegions($data){
        $out = $this->helper->get("/shipping/getCoverageRegion",$data);
        return $out;
    }
    public function closeStation($station_id) {
         $out = $this->helper->post("/station/".$station_id."/close_station",array());
         return $out;
    }
    public function getStationSubRegions($data){
        $out =  $this->helper->post("/station/get_station_coverage_district",$data);
        return $out;
    }
    public function enableStation($station_id){
        $out = $this->helper->post("/station/enableStation/{$station_id}");
        return $out;
    }
}