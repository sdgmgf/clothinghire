<?php
class TransferList extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('facility');
        $this->load->model('shipping_template_model');
	}
	
	public function transferFacilityList() {
        $params = $this->getQueryCondtion();
        $params['transfer_type'] = 1;
        if(count($params)){
        	$out = $this->facility->getTransferList($params);
        }
        if(isset($out['data'])){
        	$data = $out['data'];
        }
        $data['params'] = $params;
        $facility_list = $this->facility->getAllFacility();
		$data['facility_list'] = $facility_list['data']['facility_list'];
        $shipping_list = $this->shipping_template_model->getAllShipping(0);
        $data['shipping_list'] = $shipping_list['shipping'];
        $data   = $this->helper->merge($data);
        
        $this->load->view("transfer_facility_list",$data);
    }
    public function transferShippingList(){
		$params = $this->getQueryCondtion();
        $params['transfer_type'] = 2;
        if(count($params)){
        	$out = $this->facility->getTransferList($params);
        }
        if(isset($out['data'])){
        	$data = $out['data'];
        }
        $data['params'] = $params;
        $facility_list = $this->facility->getAllFacility();
		$data['facility_list'] = $facility_list['data']['facility_list'];
        $shipping_list = $this->shipping_template_model->getAllShipping(0);
        $data['shipping_list'] = $shipping_list['shipping'];
        $data   = $this->helper->merge($data);
        
        $this->load->view("transfer_shipping_list",$data);
    }
    public function getTransferFacilityList(){
    	$params = $this->getQueryCondtion();
        $params['transfer_type'] = 1;
        $out = $this->facility->getTransferList($params);
        echo json_encode($out);
    }
    public function getTransferShippingList(){
    	$params = $this->getQueryCondtion();
        $params['transfer_type'] = 2;
        $out = $this->facility->getTransferList($params);
        echo json_encode($out);
    }
	public function detail() {
		$transfer_shipment_id = $this->getInput('transfer_shipment_id');
		$out = $this->facility->getTransferItems($transfer_shipment_id);
		$data = $out['data'];
		$data = $this->helper->merge($data);
		$this->load->view("transfer_detail",$data);
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
    private function getQueryCondtion(){
        $cond = array();
        //获取查询条件 
        
        $end_time = $this->input->get('end_time');
        if(isset($end_time) && $end_time!=""){
            $cond['end_time'] = $end_time;
        }else{
            unset($cond['end_time']);
        }
        $product_name = $this->input->get('product_name');
        if(isset($product_name) && $product_name!=""){
            $cond['product_name'] = $product_name;
        }else{
            unset($cond['product_name']);
        }
        
        $user_name = $this->input->get('user_name');
        if(isset($user_name) && $user_name!=""){
            $cond['user_name'] = $user_name;
        }else{
            unset($cond['user_name']);
        }

        $from_facility_id = $this->input->get('from_facility_id');
        if(isset($from_facility_id) && $from_facility_id!="" ){
            $cond['from_facility_id'] = $from_facility_id;
        }else{
            unset($cond['from_facility_id']);
        }
        
        $to_facility_id = $this->input->get('to_facility_id');
        if(isset($to_facility_id) && $to_facility_id!="" ){
            $cond['to_facility_id'] = $to_facility_id;
        }else{
            unset($cond['to_facility_id']);
        }
        
        $to_shipping_id = $this->input->get('to_shipping_id');
        if(isset($to_shipping_id) && $to_shipping_id!="" ){
            $cond['to_shipping_id'] = $to_shipping_id;
        }else{
            unset($cond['to_shipping_id']);
        }
        
        $from_shipping_id = $this->input->get('from_shipping_id');
        if(isset($from_shipping_id) && $from_shipping_id!="" ){
            $cond['from_shipping_id'] = $from_shipping_id;
        }else{
            unset($cond['from_shipping_id']);
        }
        
        $created_time = $this->input->get('created_time');
        if(!count($cond)){
            if(isset($created_time) && $created_time!=""){
                $cond['created_time'] = $created_time;
            }else{
                $cond['created_time'] =  date('Y-m-d',time()).' 00:00:00';   //获取当天00:00的时间戳
            }
        }else{
            if(isset($created_time) && $created_time!=""){
                $cond['created_time'] = $created_time;
            }else{
                unset($cond['created_time']);
            }
        }
        if(isset($cond['created_time']) && isset($cond['end_time']) && $cond['created_time'] > $cond['end_time']){
            $cond = array();
        }
        return $cond;
    }
}
?>