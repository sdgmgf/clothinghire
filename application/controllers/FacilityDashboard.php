<?php

// facility_dashboard
class FacilityDashboard extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('dashboard');
      $this->load->model('common');
      $this->helper->chechActionList(array('facilityDashboard'),true);
	
    }
    
    
    
    public function query($need_transaction = 0) {
    	$cond = array();
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
        $out = $this->dashboard->getFacilityDashboard($cond);
        
        if(!isset($out['data'])){  // 调用 api 出现错误 
          $con['error_info'] = $out['error_info']; 
	    }else{  //  调用 API 成功 
	        $cond['virtual_dashboard'] = $out['data']['virtual_dashboard'] ;
	        $cond['real_dashboard'] = $out['data']['real_dashboard'] ;
	        $cond['unshipping_dashboard'] = $out['data']['unshipping_dashboard'] ;
	        $cond['shipping_hour_dashboard'] = $out['data']['shipping_hour_dashboard'] ;
	    }
	    
        //$cond['facility_list'] = $facility_list;
	    $data = $this->helper->merge($cond); 
		$this->load->view('facility_dashboard',$data);
    }
    
}
?>