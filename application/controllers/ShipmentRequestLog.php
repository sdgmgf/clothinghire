<?php

class ShipmentRequestLog extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('Pager');
		$this->load->library('Helper');
	}

	public function index() {
		$cond = array();
		$data = $this->helper->merge($cond);
		$this->load->view('shipment_request_log',$data);
	}
	public function getData() {
		$cond = array();
		
	    $facility_id = $this->input->post("facility_id");
	    if(isset($facility_id)){
	    	$cond['facility_id'] = $facility_id;
	    } else{
	    	$cond['facility_id'] = '';
	    }
	    $shipping_id = $this->input->post("shipping_id");
	    if(isset($shipping_id)){
	    	$cond['shipping_id'] = $shipping_id;
	    } else{
	    	$cond['shipping_id'] = '';
	    }
	    $type = $this->input->post("type");
	    if(isset($type)){
	    	$cond['type'] = $type;
	    } else{
	    	$cond['type'] = '';
	    }
	    $status = $this->input->post("status");
	    if(isset($status)){
	    	$cond['status'] = $status;
	    } else{
	    	$cond['status'] = '';
	    }
	    $out_order_sn = $this->input->post("out_order_sn");
	    if(isset($out_order_sn)){
	    	$cond['out_order_sn'] = $out_order_sn;
	    } else{
	    	$cond['out_order_sn'] = '';
	    }
	    $out = $this->helper->post("/ExpressRequest/list",$cond);
	    echo json_encode($out);

	}

	public function getType(){
		$out = $this->helper->get("/ExpressRequest/type");
		echo json_encode($out);
	}

	public function getStatus(){
		$out = $this->helper->get("/ExpressRequest/status");
		echo json_encode($out);
	}

	public function getDetail(){
		$cond = array();
		$ws_express_request_id = $this->input->get("ws_express_request_id");
		if(isset($ws_express_request_id)){
	    	$cond['ws_express_request_id'] = $ws_express_request_id;
	    } else{
	    	$cond['ws_express_request_id'] = '';
	    }
	    $out = $this->helper->get("/ExpressRequest/details",$cond);
	    echo json_encode($out);
	}

}
?>
