<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ProductionBatchProgressDetail extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model("productionbatch");
	    $this->load->model('common');
	    $this->helper->chechActionList(array('productionbatchprogress'),true);
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
	
  public function index()
  {
  	$production_batch_id = $this->getInput('production_batch_id');
  	if(!isset($production_batch_id)) {
  		echo '获取详情失败';
  		return false;
  	} 
  	$cond['production_batch_id'] = $production_batch_id;
  	$out = $this->productionbatch->getProductionBatchProgress($production_batch_id);
  	if($this->helper->isRestOk($out)){
  		$cond['total_list'] = $out['total_list'];
  		$cond['detail_list'] = $out['detail_list'];
   	} else {
  		echo $out['error_info'];
  		return;
  	}
  	
  	$data = $this->helper->merge($cond);
  	$this->load->view('production_batch_progress_detail',$data);
  }
}
?>