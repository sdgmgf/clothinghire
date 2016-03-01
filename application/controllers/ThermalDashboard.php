<?php

// facility_dashboard
class ThermalDashboard extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('dashboard');
      $this->load->model('common');
      $this->helper->chechActionList(array('thermalDashboard'),true);
    }
    
    
    
    public function query($need_transaction = 0) {
    	$cond = array();
    	$cond['shipping_id'] = $this->input->get('shipping_id');
        $out = $this->dashboard->getThermalDashboard($cond);
        
        if(!isset($out['data'])){  // 调用 api 出现错误 
          $con['error_info'] = $out['error_info']; 
	    }else{  //  调用 API 成功 
	        $cond['data_list'] = $out['data']['data_list'] ;
	    }
	    
        //$cond['facility_list'] = $facility_list;
	    $data = $this->helper->merge($cond); 
		$this->load->view('thermal_dashboard',$data);
    }
    
}
?>