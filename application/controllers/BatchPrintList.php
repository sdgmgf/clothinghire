<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class BatchPrintList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('batchPick');
	    $this->load->model('region');
	    $this->load->model('common');
	    $this->load->model('shipping_template_model');
	    $this->helper->chechActionList(array('batchPrintList'),true);
	}

  public function index()
  {
  	  $facility_list = $this->common->getFacilityList();
  	  if(!empty($facility_list['data'][0]['facility_id'])) {
  	  	$facility_id = $facility_list['data'][0]['facility_id'];
  	  } else {
  	  	$facility_id = 0;
  	  }
      if (isset($facility_list['error_info'])) {
          $cond['facility_list'] = array();
      } else {
	      $cond['facility_list'] = $facility_list['data'];
      }
      $shipping_list = $this->shipping_template_model->getShippingByFacility($facility_id);
      $cond['shipping_list'] = $shipping_list;
      $data = $this->helper->merge($cond); 
     $this->load->view('batch_print_list',$data);
  }
 

  // 从 get 或 post 获取数据 优先从 post 没有返回 null 
  private function getInput($name){
      $out = trim( $this->input->post($name) );
      if(isset($out) && $out!=""){
        return $out;
      }else{
        $out = trim($this->input->get($name));
        if(isset($out) && $out !="") return $out;
      }
      return null;
  }

   // 获取前端 post 传递过来的查询条件
   private function getQueryCondition( ){
      $cond = array( );  
      
      $cond['batch_status'] = 'INIT';
      
      
      $shipping_id = $this->getInput('shipping_id');
      if( isset($shipping_id)) {
      	$cond['shipping_id'] = $shipping_id;
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


   // 查询得到订单列表  
  public function query(){
  
      $cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端 
      $offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
      $limit = $cond['page_limit'];
       // 获取订单列表 
      $out = $this->batchPick->getBatchPrintList($cond,$offset,$limit);
      if(!isset($out['data'])){  // 调用 api 出现错误 
         $con['error_info'] = $out['error_info']; 
      }else{  //  调用 API 成功 
         $order_list =  $out['data']['batch_list'] ;
         $cond['order_list'] = $order_list;
            // 分页 
         $record_total = $out['data']['total'];
         $page_count = $cond['page_current']+3;
         if( count($order_list) < $limit ){
           $page_count = $cond['page_current'];
         }
         if(!empty($record_total)){
           $cond['record_total'] = $record_total;
           $page_count = ceil($record_total / $limit );
         }
         $cond['page_count'] = $page_count;
         $cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
      }
      
      $cond['webRoot'] = $this->helper->getUrl();
      $facility_list = $this->common->getFacilityList();
      if (isset($facility_list['error_info'])) {
          $cond['facility_list'] = array();
      } else {
	      $cond['facility_list'] = $facility_list['data'];
      }

      $shipping_list =  $this->shipping_template_model->getShippingByFacility($cond['facility_id']);
      $cond['shipping_list'] = $shipping_list;
       // 把数据 和 系统信息 合并后放到视图中 
      $cond ['from_page'] = 'index';
      $data = $this->helper->merge($cond); 
      
               
     if ($this->getInput('act') == "batch_print") {
     	$this->load->view('print_action',$data);
     } else {
	    $this->load->view('batch_print_list',$data);
     }
  } 
	// query  end
  public function printBatchPickBySN(){
  	$cond = array( );
  	$batch_pick_sn = $this->input->get("batch_pick_sn");
  	$out = $this->batchPick->getBatchPrintBySN($batch_pick_sn);
  	$cond['order_list'] = $out['data']['batch_detail'] ;
  	if(isset($cond['order_list'])){
  		$this->batchPick->printBatchPick($cond['order_list'][0]['batch_pick_id']);
  	}
  	$cond['batch_pick_sn'] = $batch_pick_sn;
  	$cond['webRoot'] = $this->helper->getUrl();
  	$cond ['from_page'] = 'index';
  	$data = $this->helper->merge($cond);
  	$this->load->view('print_action',$data);
  }
    
  public  function cityList(){
  	$province_id = $this->getInput('province_id');
  	$city_list = $this->region->getRegion($province_id, 2);
  	echo json_encode(isset($city_list['data']) ? $city_list['data'] : array());
  }
  
  public function batchPickDetail(){
  	$cond = array( );
  	$batch_pick_id = $this->input->get("batch_pick_id");
  	$out = $this->batchPick->getBatchPrint($batch_pick_id);
  	$cond['order_list'] = $out['data']['batch_detail'] ;
  	$cond['webRoot'] = $this->helper->getUrl();
  	$cond['batch_pick_id'] = $batch_pick_id;
  	$data = $this->helper->merge($cond);
  	$this->load->view('batch_pick_detail',$data);
  }
  
  public function facilityShipping(){
  	$facility_id = $this->getInput('facility_id');
  	$shipping_list = $this->shipping_template_model->getShippingByFacility($facility_id);
  	echo json_encode( array( "shipping_list" => $shipping_list['shipping']));
  }

}
?>