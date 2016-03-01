<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 快递
class Carriage extends CI_Model {

    private $CI;
    private $helper;

    function __construct() {
        parent::__construct();
        if (!isset($this->CI)) {
            $this->CI = & get_instance();
        }
        if (!isset($this->helper)) {
            $this->CI->load->library('Helper');
            $this->helper = $this->CI->helper;
        }
    }

    public function getAreaRegion() {
        $out = $this->helper->get('/admin/area/region');
        $result = array();
        if ($this->helper->isRestOk($out)) {
            $result = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function addCarriage($cond) {
        $out = $this->helper->post('/carriage/addCarriage', $cond);
        if ($this->helper->isRestOk($out)) {
            $result = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function getCarriageRule() {
        $out = $this->helper->get('/carriage/getCarriageRule');
        if ($this->helper->isRestOk($out)) {
            $result = $out;
        } else {
            $result['error_info'] = '获取规则名称失败';
        }
        return $result;
    }

    public function getCarriageFreight($cond) {
        $out = $this->helper->get('/carriage/getCarriageFreight', $cond);
        if ($this->helper->isRestOk($out)) {
            $result = $out;
        } else {
            $result['error_info'] = '获取快递费用与规则失败';
        }
        return $result;
    }

    public function getParentRegionId($cond){
        $out = $this->helper->get('/regions/getParentRegionId' , $cond );
        if($this->helper->isRestOk($out)){
            return $out['data'];
        }else{
            return ;
        }
    }
    
}
