<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理商品相关的逻辑 为 商品 控制器服务 
class Coverage extends CI_Model {

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

    
    public function getFacilityCoverage($data){
    	$out = $this->helper->get("/coverage/getFacilityCoverage",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    public function getFacilityAvaiableCoverage($data){
    	
    	$out = $this->helper->get("/coverage/getFacilityAvaiableCoverage",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    
    public function addFacilityCoverage($facility_id,$shipping_id,$data){
    	$out = $this->helper->post("/coverage/".$facility_id."/shipping/".$shipping_id."/addCoverage",$data);
    	if($this->helper->isRestOk($out)) {
    		return array("success"=>"true");
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    public function getFacilityCoverageProvinces($facility_id){
     	$out = $this->helper->get("/coverage/".$facility_id."/getFacilityCoverageProvinces");
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
    }
    public function getFacilityCoverageCitys($facility_id,$parent_region_id){
     	$out = $this->helper->get("/coverage/".$facility_id."/getFacilityCoverageCitys",array("parent_region_id" => $parent_region_id));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
    }
    public function getFacilityCoverageDistricts($facility_id,$parent_region_id){
     	$out = $this->helper->get("/coverage/".$facility_id."/getFacilityCoverageDistricts",array("parent_region_id" => $parent_region_id));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
    }
    public function getFacilityInCityCoverage($data){
    	$out = $this->helper->get("/coverage/getFacilityInCityCoverage",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    public function getFacilityInCityAvaiableCoverage($facility_id,$shipping_id,$data){
    	$out = $this->helper->get("/coverage/".$facility_id."/".$shipping_id."/getFacilityInCityAvaiableCoverage",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    public function addFacilityInCityCoverage($facility_id,$shipping_id,$data){
    	$out = $this->helper->post("/coverage/".$facility_id."/".$shipping_id."/addFacilityInCityCoverage",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    
}