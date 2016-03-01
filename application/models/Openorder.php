<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Openorder extends CI_Model {

    private $CI;
    private $helper;
    function __construct(){
        parent::__construct();
        if(!isset($this->CI)){
            $this->CI = & get_instance();
        }
        if(!isset($this->helper)){
            $this->CI->load->library('Helper'); 
            $this->helper = $this->CI->helper;
        }
    }
    
    public function getOpenOrderList($cond = array()){
        $out = $this->helper->get("/admin/openOrder/list/show",$cond);
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function getCodShippingList($cond = array()){
        $out = $this->helper->get("/admin/shipping/shippinglist/show",$cond);
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function updateStatus($cond = array()){
        $out = $this->helper->post("/admin/openOrder/update",$cond);
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function getPinXiaoZhanDeatil($tracking_number){
        $cond = array('tracking_number'=>$tracking_number);
        $out = $this->helper->get("/admin/pinXiaoZhan/showDetail",$cond);
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

      public function signatureConfirmation($tracking_number){
        $cond = array('tracking_number'=>$tracking_number);
        $out = $this->helper->post("/admin/pinXiaoZhan/signatureConfirmation",$cond);
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }
      public function showBenbenCannotship($cond = array()){
        $out = $this->helper->get("/benbencannotship/cannotship",$cond);
        return $out; 
    }
}