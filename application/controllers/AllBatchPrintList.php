<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class AllBatchPrintList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager'); 
	    $this->load->library('Helper'); 
	    $this->load->model('batchPick');
	    $this->load->model('productmodel');
	    $this->load->model('common');
	    $this->load->model('shipping_template_model');
	    $this->helper->chechActionList(array('allBatchPrintList'),true);
	}

  public function index()
  {
  	$facility_list = $this->common->getFacilityList();
  	if(!empty($facility_list['data'][0]['facility_id'])){
  		$facility_id = $facility_list['data'][0]['facility_id'];
  	} else {
  		$facility_id = 0;
  	}
  	
  	$product_list = $this->productmodel->productListFromBatchPick($facility_id);
  	$cond['product_list'] = $product_list;
  	$shipping_list = $this->shipping_template_model->getShippingByFacility($facility_id);
  	$cond['shipping_list'] = $shipping_list;
  	
  	
      if (isset($facility_list['error_info'])) {
          $cond['facility_list'] = array();
      } else {
	      $cond['facility_list'] = $facility_list['data'];
      }
  	
  	$data = $this->helper->merge($cond);
    $this->load->view('all_batch_print_list',$data);
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
  
  	$shipping_id = $this->getInput('shipping_id');
  	if( isset($shipping_id)) {
  		$cond['shipping_id'] = $shipping_id;
  	}
  	
  	$facility_id = $this->getInput('facility_id');
  	if( isset($facility_id)) {
  		$cond['facility_id'] = $facility_id;
  	}
  	$tracking_number = $this->getInput('tracking_number');
  	if (isset($tracking_number)) {
  		$cond['tracking_number'] = $tracking_number;
  	}
  	$batch_pick_sn = $this->getInput('batch_pick_sn');
  	if(isset($batch_pick_sn)){
  		$cond['batch_pick_sn'] = $batch_pick_sn;
  	}
  	
  	$start_time = $this->getInput('start_time');
  	if(isset($start_time)){
  		$cond['start_time'] = $start_time;
  	}
  	
  	$end_time = $this->getInput('end_time');
  	if(isset($end_time)){
  		$cond['end_time'] = $end_time;
  	}
  	$batch_status = $this->getInput('status');
  	if(isset($batch_status)){
  		$cond['batch_status'] = $batch_status;
  	}
  	$mobile = $this->getInput("mobile");
  	if(isset($mobile)) {
  		$cond['mobile'] = $mobile;
  	}
  	 $print_user = $this->getInput('print_user');
      $shipping_user = $this->getInput('shipping_user');
      if ($print_user) {
      	$cond['print_user'] = $print_user;
      }
      if ($shipping_user) {
      	$cond['shipping_user'] = $shipping_user;
      }
      
    //指定类型，sql加入group by batch_pick_id
   	$cond['type'] = 'allbatchpicklist';
  
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

    $product_id = $this->getInput('product_id');
    if( isset($product_id)) {
        $cond['product_id'] = $product_id;
    }

  	return $cond;
  }
  
  
  // 打印批拣单
  public function printBatchPick() {
  	$batch_pick_id = $this->getInput('batch_pick_id');
  	$result = $this->batchPick->getBatchPickInfo($batch_pick_id);
  	if (isset($result['error_info'])) {
  		die("{$batch_pick_id} 获取批拣单失败" . $result['error_info']);
  	} else {
  		$cond['order'] = $result['data']['batch_info'];
	  	$cond['sn_code_img'] = $this->helper->getUrl() . "codeImg?barcode="  . $result['data']['batch_info']['batch_pick_sn'] . "&height=80&width=500&text=0";
	  	$cond['min_code_img'] = $this->helper->getUrl() . "codeImg?barcode=" . $result['data']['batch_info']['min_order']['tracking_number'] . "&height=80&width=500&text=0";
	  	$cond['max_code_img'] = $this->helper->getUrl() . "codeImg?barcode=" . $result['data']['batch_info']['max_order']['tracking_number'] .  "&height=80&width=500&text=0";
	  	$data = $this->helper->merge($cond); 
	  	$this->load->view('batch_print', $data);
  	}
  }
  
  // 查询得到订单列表
  public function query(){
  
  	$cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端
    //var_dump($cond);die();
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
  	
  	if(!empty($cond['facility_id'])) {
  		$product_list = $this->productmodel->productListFromBatchPick($cond['facility_id']);
  		$shipping_list = $this->shipping_template_model->getShippingByFacility($cond['facility_id']);
  	} else {
  		$product_list = $this->productmodel->productListFromBatchPick(0);
  		$shipping_list = $this->shipping_template_model->getShippingByFacility(0);
  	}
  	$cond['product_list'] = $product_list;
  	$cond['shipping_list'] = $shipping_list;
  	$facility_list = $this->common->getFacilityList();
      if (isset($facility_list['error_info'])) {
          $cond['facility_list'] = array();
      } else {
	      $cond['facility_list'] = $facility_list['data'];
      }
    $product_name = $this->getInput('product_name');
  	// 把数据 和 系统信息 合并后放到视图中
  	$data = $this->helper->merge($cond);
    if(!empty($product_name)){
        $data['product_name'] = $product_name;
    }
  	$this->load->view('all_batch_print_list',$data);
  }                                   // query  end
  public function facilityProduct(){
  	$facility_id = $this->getInput('facility_id');
  	$product_list = $this->productmodel->productListFromBatchPick($facility_id);
  	echo json_encode( array( "product_list" => $product_list['product']));
  }
  
  public function facilityShipping(){
  	$facility_id = $this->getInput('facility_id');
  	$shipping_list = $this->shipping_template_model->getShippingByFacility($facility_id);
  	echo json_encode( array( "shipping_list" => $shipping_list['shipping']));
  }
}
?>