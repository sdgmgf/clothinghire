<?php

// 盘点
class StocktakeMaterialList extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('stocktakematerial');
      $this->load->model('common');
      $this->load->model('productmodel');
    }
    public function index() {
        $cond = array();
        $cond['product_type'] = $this->getInput('product_type');
        if ($cond['product_type'] == 'supplies' && !$this->helper->chechActionList(array('suppliesInventoryManager','suppliesCaigouManager'))) {
        	die("无耗材权限");
        }
        if ($cond['product_type'] != 'supplies' && !$this->helper->chechActionList(array('wuliaoManager','caigouManager'))) {
        	die("无商品权限");
        }
        $facility_list = $this->common->getFacilityList();
        $facility_id = $this->getInput('facility_id');
        if (! $facility_id) {
        	$facility_id = $facility_list['data'][0]['facility_id'];
        }
        $cond['facility_id'] = $facility_id;
        $product_name = $this->getInput('product_name');
        if (isset($product_name) && $product_name) $cond['product_name'] = trim($product_name);
        
        $product_list = $this->stocktakematerial->getStocktakeMaterialProductList($cond); 
        
        $cond['product_list'] = $product_list['data']['product_list'];
        $cond['facility_list'] = $facility_list['data'];
        $data = $this->helper->merge($cond); 
        $this->load->view('stocktake_material',$data);
    }
    public function query() {
    	$cond = $this->getQueryCondition();
    	$cond['product_type'] = $this->getInput('product_type');
        if ($cond['product_type'] == 'supplies' && !$this->helper->chechActionList(array('suppliesInventoryManager','suppliesCaigouManager'))) {
        	die("无耗材权限");
        }
        if ($cond['product_type'] != 'supplies' && !$this->helper->chechActionList(array('wuliaoManager', 'caigouManager'))) {
        	die("无商品权限");
        }
    	$facility_list = $this->common->getFacilityList();
    	if (isset($facility_list['error_info'])) {
		    $facility_list = array();
		} else {
	    	$facility_list = $facility_list['data'];
		}
		if (!isset($facility_list) || empty ($facility_list) || ! is_array($facility_list)) {
			die("无仓库权限");
		}
		if (! isset($cond['facility_id'])) {
			$cond['facility_id'] = $facility_list[0]['facility_id'];
		}
		
		/*
		if (! isset($cond['status']) && $this->getInput('status') != "all") {
			$cond['status'] = 0;
		}
		*/
    	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
        $limit = $cond['page_limit'];
        
        $out = $this->stocktakematerial->getStocktakeMaterialList($cond,$offset,$limit);
        if(!isset($out['data'])){  // 调用 api 出现错误 
          $con['error_info'] = $out['error_info']; 
	    }else{  //  调用 API 成功 
	        $stocktake_list =  $out['data']['stocktake_list'] ;
	        $cond['stocktake_list'] = $stocktake_list;
	        // 分页 
	        $record_total = $out['data']['total'];
	        $page_count = $cond['page_current']+3;
	        if(count($stocktake_list) < $limit ){
	            $page_count = $cond['page_current'];
	        }
	        if(!empty($record_total)){
	            $cond['record_total'] = $record_total;
	            $page_count = ceil($record_total / $limit );
	        }
	        $cond['page_count'] = $page_count;
	        $cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
	    }
	    
        $cond['facility_list'] = $facility_list;
	    $data = $this->helper->merge($cond); 
		$this->load->view('stocktake_material_list',$data);
    }
    
    public function createStocktakeMaterial() {
    	$cond = $this->getQueryCondition();
    	$out = $this->stocktakematerial->createStocktakeMaterial($cond);
    	echo json_encode($out);
    }
    
    public function createStocktakeMaterialBatch(){
    	$cond= $this->getQueryCondition();
    	$cond['product_type'] = $this->getInput('product_type');
    	$out=$this->stocktakematerial->createStocktakeMaterialBatch($cond);
    	echo json_encode($out);
    }
    
    
    public function executeStocktake() {
    	$cond = array();
	    $cond['stocktake_material_id'] = $this->getInput('stocktake_material_id'); 
	    $cond['quantity'] = $this->getInput('quantity');
	    $out = $this->stocktakematerial->executeStocktake($cond); 
	    echo json_encode($out);
    }
    public function checkStocktake() {
    	$cond = array();
	    $cond['stocktake_material_id'] = $this->getInput('stocktake_material_id'); 
	    $cond['check'] = $this->getInput('check');
	    $cond['note'] = $this->getInput('note');
	    $out = $this->stocktakematerial->checkStocktake($cond); 
	    echo json_encode($out);
    }
    
     private function getQueryCondition() {
        $cond = array( );  
        $cond['start_time'] = date('Y-m-d 06:00:00');
        
        $start_time =  $this->getInput('start_time');
        if(isset($start_time)) $cond['start_time'] = $start_time;// 时间段起始 
        $end_time =  $this->getInput('end_time');// 时间段终止
        if(isset($end_time)) $cond['end_time'] = $end_time;
        
        $product_id =  $this->getInput('product_id');
        if(isset($product_id)) $cond['product_id'] = $product_id;
        
        $container_id =  $this->getInput('container_id');
        if(isset($container_id)) $cond['container_id'] = $container_id;
        
        $product_name =  $this->getInput('product_name');
        if(isset($product_name)) $cond['product_name'] = $product_name;
        
        $facility_id =  $this->getInput('facility_id');
        if(isset($facility_id)) $cond['facility_id'] = $facility_id;
        $status = $this->getInput('status');
        if (isset($status) && $status != "all") $cond['status'] = $status;
        
        
        $page_current = $this->getInput('page_current');
        if(!empty($page_current)) {
          $cond['page_current'] = $page_current;
        }else{
          $cond['page_current'] = 1;
        }
        $page_limit = $this->getInput('page_limit');    
        if(!empty($page_limit)) {
          $cond['page_limit'] = $page_limit;
        }else{
          $cond['page_limit'] = 50;
        }
        return $cond;
     }
     
    
     // 从 get 或 post 获取数据 优先从 post 没有返回 null 
    private function getInput($name) {
        $out = trim($this->input->post($name));
        if(isset($out) && $out!=""){
          return $out;
        }else{
          $out = trim($this->input->get($name));
          if(isset($out) && $out !="") return $out;
        }
        return null;
    }
    
    public function getProductList(){
    	$out = array();
    	$out = $this->productmodel->getProductList(array());
    	if(isset($out)&&isset($out['product_list'])){
    		echo json_encode(array('success'=>'success','product_list'=>$out['product_list']));
    	}else{
    		echo json_encode(array('success'=>'failed'));
    	}
    }
}
?>