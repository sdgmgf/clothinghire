<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ProductionBatchList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model("productionbatch");
	    $this->load->model('common');
	    $this->load->model('facility');
	    $this->helper->chechActionList(array('productionbatchlist'),true);
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			return $out;
		} else {
			$out = trim( $out );
		}
	
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}
	
   private function getQueryCondition(){
      $cond = array( );

      $production_batch_date = $this->getInput('production_batch_date');
      if( isset($production_batch_date)) {
      	$cond['production_batch_date'] = $production_batch_date;
      } 
      $production_batch_sn = $this->getInput('production_batch_sn');
      if( isset($production_batch_sn)) {
      	$cond['production_batch_sn'] = $production_batch_sn;
      }
      
      $production_batch_type = $this->getInput('production_batch_type');
      if( isset($production_batch_type)) {
      	$cond['production_batch_type'] = $production_batch_type;
      }
      
      $status = $this->getInput('status');
      if( isset($status)) {
      	$cond['status'] = $status;
      } else{
      	$cond['status'] = 'DOING';
      }
      
      $facility_id = $this->getInput('facility_id');
      if( isset($facility_id)) {
      	$cond['facility_id'] = $facility_id;
      }
      
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
        $cond['page_limit'] = 10;
      }
      
      return $cond;
   }
	
  public function index()
  {
  	$cond = $this->getQueryCondition();
	$facility_list = $this->common->getFacilityList();
	if(empty($cond['facility_id']) && !empty($facility_list['data'][0]['facility_id'])) {
		$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
	}
	
	if(empty($cond['facility_id'])) {
		die('无仓库权限');
	}

  	$cur_facility = $this->facility->getFacilityByFacilityId($cond['facility_id']);
	if($cur_facility['schedule_mode'] == 'manual_schedule_manual_shipping') {
		echo '该仓库没有开通此功能';
	} else {
		$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
		$limit = $cond['page_limit'];
		$out = $this->productionbatch->getProductionBatchList( $cond,$offset,$limit);
		if(!isset($out['data'])){  // 调用 api 出现错误
	  		$con['error_info'] = $out['error_info'];
	  	}else{  //  调用 API 成功
	  		$cond['production_batch_list'] = $out['data']['production_batch_list'];
	  		// 分页
	  		$record_total = $out['data']['total'];
	  		$page_count = $cond['page_current']+3;
	  		if( count($cond['production_batch_list']) < $limit ){
	  			$page_count = $cond['page_current'];
	  		}
	  		if(!empty($record_total)){
	  			$cond['record_total'] = $record_total;
	  			$page_count = ceil($record_total / $limit );
	  		}
	  		$cond['page_count'] = $page_count;
	  		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
	  	}
	}
	
	if (isset($facility_list['error_info'])) {
		$cond['facility_list'] = array();
	} else {
		if(isset($facility_list['data'])){
			$cond['facility_list'] = $facility_list['data'];
		}
	}
  	
  	$type_list = $this->common->getProductionBatchTypeList();
  	if(!empty($type_list['data'])) {
  		$cond['type_list'] = $type_list['data'];
  	}
  	
  	$data = $this->helper->merge($cond);
  	$this->load->view('production_batch_list',$data);
  }
  public function doPrint(){
  	$production_batch_id = $this->getInput('production_batch_id');
  	if(!isset($production_batch_id)){
  		echo '获取提货明细失败';
  		return false;
  	}
  	
  	$out = $this->productionbatch->getProductionItemList( $production_batch_id);
	if($this->helper->isRestOk($out)){
		$cond['item_list'] = $out['data'];
	} else{
		echo $out['error_info'];
		return false;
	}
	
	$out = $this->productionbatch->getProductionBatchSummary($production_batch_id);
	if($this->helper->isRestOk($out)){
		$cond['summary'] = $out;
	} else{
		echo $out['error_info'];
		return false;
	}
  	$data = $this->helper->merge($cond);
  	$this->load->view('production_batch_print',$data);
  }
  public function doPrint2(){
  	$production_batch_id = $this->getInput('production_batch_id');
  	if(!isset($production_batch_id)){
  		echo '获取提货明细失败';
  		return false;
  	}
  	$data = $this->helper->merge(array("production_batch_id"=>$production_batch_id));
  	$this->load->view('production_batch_print2',$data);
  }
  public function getPickUpRawMaterialAndSupplies(){
  	$production_batch_id = $this->getInput('production_batch_id');
  	if(!isset($production_batch_id)){
  		echo '请输入production_batch_id';
  		return false;
  	}
  	$out_detail = $this->productionbatch->getProductionBatchItemDetail( $production_batch_id);
  	
	$out_summary = $this->productionbatch->getProductionBatchSummary($production_batch_id);
	$out = array_merge($out_detail,$out_summary);
	echo json_encode($out);
  }
}
?>