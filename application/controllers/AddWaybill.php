<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class AddWaybill extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('waybill');
	    $this->load->model('region');
	    $this->load->model('common');
	    $this->helper->chechActionList(array('batchPickDeliver'),true);
	}

  public function index($cond = array())
  {
  	  $cond = $this->getQueryCondition();
  	  $facility_id = $cond['facility_id'];
  	  $cond = $this->waybill->getToWaybillList($cond);
  	  $facility_list = $this->common->getFacilityList();
	  if (isset($facility_list['error_info'])) {
			die();
	  } else {
		  if(isset($facility_list['data'])){
				$cond['facility_list'] = $facility_list['data'];
		  }
	  }
	  $cond['facility_id'] = $facility_id;
  	  $cond ['webRoot'] = $this->helper->getUrl ();
	  $data = $this->helper->merge ( $cond );
      $this->load->view('add_waybill',$data);
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
	  	$cond = array();
	  	$facility_id = $this->getInput('facility_id');
	  	if(isset($facility_id)) {
	  		$cond['facility_id'] = $facility_id;
	  	} else {
	  		$facility_list = $this->common->getFacilityList();
	  		if (isset($facility_list['error_info'])) {
	  			$cond['facility_id'] = '';
	  		} else {
	  			if(isset($facility_list['data'][0]['facility_id'])){
	  				$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
	  			}
	  		}
	  	}
	  	return $cond;
   }
  // query  end
  public function createWaybill(){
	  $shipping_id = $this->getInput('shipping_id');
	  $facility_id = $this->getInput('facility_id');
	  $num = $this->getInput('num');
	  $user_id = $this->getInput('user_id');
	  $cond['shipping_id'] =$shipping_id;
	  $cond['facility_id'] =$facility_id;
	  $cond['num'] =$num;
	  $cond['user_id'] =$user_id;
	  $result = $this->waybill->createWaybill($cond);
	  if($result['result'] == 'ok'){
	  	 $cond = array();
	  	 $cond = $result['waybill_detail'];
	  	 $cond ['webRoot'] = $this->helper->getUrl ();
		 $data = $this->helper->merge ( $cond );
	     $this->load->view('print_waybill',$data);
	  }else{
	  	var_dump($result['error_info']);
	  	$this->index();
	  }
  }
}
?>