<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Stocktakematerial extends CI_Model {

    private $CI;
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
    
    public function getStocktakeMaterialProductList($cond = array()){
    	$out =  $this->helper->get("/admin/stocktake_material_product_list", $cond);
    	$result = array();
    	if($this->helper->isRestOk($out)){
    		$result['data'] = $out;
    	}else{
    		$result['error_info'] = $out['error_info'];
    	}
    	return $result;
    }
    
    public function createStocktakeMaterial($cond) {
    	$out =  $this->helper->post("/admin/create_stocktake_material",$cond);
    	if($this->helper->isRestOk($out)){
    		$this->helper->log("createStocktakeMaterial OK " . json_encode($cond));
    		$info['success'] = "OK";
    	}else{
    		if(isset($out['error_info'])) {
    			$this->helper->log("createStocktakeMaterial FAIL " . json_encode($cond) . " error_info {$out['error_info']}");
    			$info['error_info'] = $out['error_info'];
    		}
    	}
    	return $info ;
    }
    
    public function createStocktakeMaterialBatch($cond){
    	$out=$this->helper->post("/admin/create_stocktake_material_batch",$cond);
    	if($this->helper->isRestOK($out)){
    		$this->helper->log("createStocktakeMaterialBatch OK" . json_encode($cond));
    		$info['success'] = "OK";
    	}else{
    		if(isset($out['error_info'])){
    			$this->helper->log("createStocktakeMaterialBatch FAIL" . json_encode($cond) . "error_info {$out['error_info']}");
    			$info['error_info'] = $out['error_info'];
    		}
    	}
    	return $info;
    }
    public function getStocktakeMaterialList($cond = array(),$offset,$limit){
    	$cond['offset'] = $offset;
    	$cond['size'] = $limit;
    	
    	$out =  $this->helper->get("/admin/stocktake_material_list",$cond);
    	
    	$result = array();
    	if($this->helper->isRestOk($out)){
    		$result['data'] = $out;
    	}else{
    		$result['error_info'] = $out['error_info'];
    	}
    	return $result;
    }
    public function executeStocktake($cond) {
    	$out =  $this->helper->post("/admin/execute_stocktake_material",$cond);
    	$info = array();
    	if($this->helper->isRestOk($out)){
    		$this->helper->log("executeStocktakeMaterial OK " . json_encode($cond));
    		$info['success'] = "OK";
    	}else{
    		if(isset($out['error_info'])) {
    			$this->helper->log("executeStocktakeMaterial FAIL " . json_encode($cond) . " error_info {$out['error_info']}");
    			$info['error_info'] = $out['error_info'];
    		}
    	}
    	return $info ;
    }
    public function checkStocktake($cond) {
    	$out =  $this->helper->post("/admin/check_stocktake_material",$cond);
    	if($this->helper->isRestOk($out)){
    		$this->helper->log("checkStocktakeMaterial OK " . json_encode($cond));
    		$info['success'] = "OK";
    	}else{
    		if(isset($out['error_info'])) {
    			$this->helper->log("checkStocktakeMaterial FAIL " . json_encode($cond) . " error_info {$out['error_info']}");
    			$info['error_info'] = $out['error_info'];
    		}
    	}
    	return $info ;
    }
}