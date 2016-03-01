<?php
class OpenOrderList extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->model('Openorder');
      $this->load->library('Pager');
    }
     private function getInput($name) {
        $out = $this->input->post($name);
        if(isset($out) && $out!=""){
          return $out;
        }else{
          $out = trim($this->input->get($name));
          if(isset($out) && $out !="") return $out;
        }
        return null;
    }
     public function index() {
     	if(!$this->helper->chechActionList(array('OpenOrderList'))) {
			die("无权限");
		}
		$cond = $this->getQueryCondition();
        $CodShippingList = $this->Openorder->getCodShippingList($cond);
        if (isset($CodShippingList['error_info']) || empty($CodShippingList)) {
            $CodShippingList = array();
        } else {
            $CodShippingList = $CodShippingList['data']['shipping'];
        }
        $offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
        $limit = $cond['page_limit'];
        $cond['offset'] = $offset;
        $cond['size'] = $limit;
        $OpenOrderList = $this->Openorder->getOpenOrderList($cond);
        if (isset($OpenOrderList['error_info']) || empty($OpenOrderList)) {
            $OpenOrderList = array();
        } else {
            $record_total = $OpenOrderList['data']['total']; 
            $page_count = $cond['page_current']+3;
            if(count($OpenOrderList['data']['order_list']) < $limit ){
                $page_count = $cond['page_current'];
            }
            if(!empty($record_total)){
                $cond['record_total'] = $record_total;
                $page_count = ceil($record_total / $limit );
            }
            $cond['page_count'] = $page_count;
            $cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
            $OpenOrderList = $OpenOrderList['data']['order_list'];
            $cond['CodShippingList'] = $CodShippingList;
            $cond['OpenOrderList'] = $OpenOrderList;
        }
        $data = $this->helper->merge($cond);
        $this->load->view('open_order_list',$data);
     }
    private function getQueryCondition() {
    	$cond = array();
    	$shipping_id= $this->getInput('shipping_id');
    	if (isset($shipping_id) && $shipping_id) {
        	$cond['shipping_id'] = $this->getInput("shipping_id");
        }
        else{
    		$cond['shipping_id'] = '';
    	}
        $status= $this->getInput('status');
    	if (isset($status) && $status) {
        	$cond['status'] = $this->getInput("status");
        }
        elseif($status == '0'){
    		$cond['status'] = '0';
    	}else{
            $cond['status'] = "2";
        }
        $tracking_number= $this->getInput('tracking_number');
    	if (isset($tracking_number) && $tracking_number) {
        	$cond['tracking_number'] = $tracking_number;
        } 
        else{
    		$cond['tracking_number'] = '';
    	} 
        $start_time = $this->getInput('start_time');
            if (isset($start_time) && $start_time) {
            $cond['start_time'] = $start_time;
        }

        $end_time = $this->getInput('end_time');
            if (isset($end_time) && $end_time) {
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
            $cond['page_limit'] = 20;
        }
        $order_status = $this->getInput('order_status');
        if(!empty($order_status)){
            $cond['order_status'] = $order_status;
        } 
        return $cond;
    }
    
    public function updateStatus(){
        $cond = array();
        $cond['open_order_ids'] = $this->getInput('open_order_id'); 
        $cond['status'] = $this->getInput('status');
        $out = $this->Openorder->updateStatus($cond); 
        echo json_encode($out);
    }
}
?>
