<?php

class Carrier extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model('carriermodel');
        $this->helper->chechActionList(array('carrierList','addCarrier','editCarrier'),true);
	}
    //查询
	public function index(){
        $cond = $this->getQueryCondition();
        $result= $this->carriermodel->getCarrierList($cond);
        $cond['carrier_list']  = isset($result['carrier_list'])? $result['carrier_list'] :  array();
        $data = $this->helper->merge($cond);
        $this->load->view('carrier_list',$data);
	}
    
    public function getCarrierDetail(){
        $cond = array();
        $cond['shipping_id'] = $this->getInput('shipping_id');
        if(empty($cond['shipping_id'])){
            print_r(json_encode(array('error_info'=>'缺少承运商序号')));
        }
        $result = $this->carriermodel->getCarrierList($cond);
        if(!isset($result['carrier_list']) || empty($result['carrier_list'])){
            print_r(json_encode(array('error_info'=>'没有承运商信息')));
        }
        $data = array(
            'carrier_detail' => $result['carrier_list'][0],
        );
        print_r(json_encode($data));
    }
    
    //添加或者修改承运商
    public function createOrModifyCarrier(){
        $cond = $this->getCreateOrModifyCondition();
        if(isset($cond['error_info']) && !empty($cond['error_info'])){
            print_r(json_encode(array('error_info'=>$cond['error_info'],)));
            return false;
        }
        if(isset($cond['shipping_id']) && !empty($cond['shipping_id'])){
            $out = $this->carriermodel->modifyCarrier($cond);
        } else {
            $out = $this->carriermodel->addCarrier($cond);
        }
        print_r(json_encode($out));
    }
    //禁用或者启用承运商
    public function changeCarrierStatus(){
        $shipping_id = $this->getInput('shipping_id');
        if(empty($shipping_id)){
            print_r(json_encode(array('error_info'=>'缺少承运商信息')));
        }
        $enabled  = $this->getInput('enabled');
        if(null == $enabled){
            print_r(json_encode(array('error_info'=>'缺少承运商状态')));
        } 
        $out = $this->carriermodel->changeCarrierStatus($shipping_id, $enabled);
        print_r(json_encode($out)); 
    }
    
    //查询参数验证
	private function getQueryCondition(){
		$cond = array();
        $enable = $this->getInput('enabled');
        if($enable != null){
            $cond['enabled'] = $enable;
        }
        $shipping_type = $this->getInput('shipping_type');
        if(isset($shipping_type) && !empty($shipping_type)){
            if($shipping_type != 'is_not_cod'){
                $cond[$shipping_type] = 1;
            } else{
                $cond['is_cod'] = 0;
            }
        }
        $support_transfer = $this->getInput('support_transfer');
        if($support_transfer != null){
            $cond['support_transfer'] = $support_transfer;
        }
        $support_thermal = $this->getInput('support_thermal');
        if($support_thermal != null){
            $cond['support_thermal'] = $support_thermal;
        }
        $shipping_name = $this->getInput('shipping_name');
        if(!empty($shipping_name)){
            $cond['shipping_name'] = $shipping_name;
        }
		return $cond;
	}
    
    //参数验证
    private function getCreateOrModifyCondition(){
        $cond = array();
        //参数可不存在,但不能为空
        $cond['send_order_url'] = $this->getInput('send_order_url');
        $cond['regex'] = $this->getInput('regex');
        $cond['get_station_url'] = $this->getInput('get_station_url');
        $cond['open_key'] = $this->getInput('open_key');
        foreach($cond as $key => $val){
            if(empty($val) || $val == null){
                unset($cond[$key]);
            }  
        }
        if(!empty($cond)){
            if(false == $this->helper->chechActionList(array('addCarrier','editCarrier'),false)){
               $cond['error_info'] = '权限不足';
               return $cond;
            }
        }
        $shipping_id = $this->getInput('shipping_id');
        if(isset($shipping_id) && !empty($shipping_id)){
            $cond['shipping_id'] = $shipping_id;
        }
        //参数必须存在且不能为空
        $cond['shipping_name'] = $this->getInput('shipping_name');
        $cond['is_cod'] = $this->getInput('is_cod');
        $cond['is_self'] = $this->getInput('is_self');
        $cond['support_transfer'] = $this->getInput('support_transfer');
        $cond['support_thermal'] = $this->getInput('support_thermal');
        $cond['service_id'] = $this->getInput('service_id');
        $cond['enabled'] = $this->getInput('enabled');
        foreach($cond as $key => $value){
            if(null == $value){
                if(isset($cond['error_info'])){
                    $cond['error_info'] .= ",".$key."缺失";
                } else {
                    $cond['error_info'] = $key."缺失";
                }
            }
        }
        //参数可为空
        $cond['sync_type'] = $this->getInput('sync_type');
        return $cond;
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
}

?>






