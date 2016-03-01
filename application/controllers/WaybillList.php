<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class WaybillList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('waybill');
	    $this->load->model('region');
	    $this->load->model('common');
	    $this->helper->chechActionList(array('queryWaybill'),true);
	}

  public function index($cond = array())
  {
  	$cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端
  	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
  	$limit = $cond['page_limit'];
  	// 获取订单列表
  	$out = $this->waybill->getWaybillList($cond,$offset,$limit);
//  	var_dump($out);
  	if(!isset($out['data'])){  // 调用 api 出现错误
  		$con['error_info'] = $out['error_info'];
  	}else{  //  调用 API 成功
  		$data_list =  $out['data']['data_list'] ;
  		$cond['data_list'] = $data_list;
  		// 分页
  		$record_total = $out['data']['total'];
  		$page_count = $cond['page_current']+3;
  		if( count($data_list) < $limit ){
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
  	// 把数据 和 系统信息 合并后放到视图中
  	$data = $this->helper->merge($cond);

  	$this->load->view('waybill_list',$data);
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
  // 获取前端 post 传递过来的查询条件
  private function getQueryCondition( ){
  	$cond = array( );
  	
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

  	$start_time = $this->getInput('start_time');
  	if(isset($start_time)){
  		$cond['start_time'] = $start_time;
  	}
  	
  	$end_time = $this->getInput('end_time');
  	if(isset($end_time)){
  		$cond['end_time'] = $end_time;
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
  		$cond['page_limit'] = 50;
  	}
  
  	return $cond;
  }
  // query  end
  public function WaybillDetail(){
	 
  }
  
}
?>