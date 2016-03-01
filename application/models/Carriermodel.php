<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 承运商
class Carriermodel extends CI_Model {

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
    //获取承运商列表
    public function getCarrierList($data) {
       $out =  $this->helper->get('/carrierManage/getCarrierList', $data);
       return $out;
    }   
    //修改承运商
    public function modifyCarrier($data){
       $out = $this->helper->post("/carrierManage/editCarrierDetail",$data);
       return $out;
    }
    //修改承运商状态
    public function changeCarrierStatus($shipping_id, $enabled){
        $out = $this->helper->post('/carrierManage/changeCarrierStatus',array('shipping_id'=>$shipping_id, 'enabled'=>$enabled));
        return $out;
    }
    //新增承运商
    public function addCarrier($data){
       $out = $this->helper->post("/carrierManage/addCarrier",$data);
       return $out;
    }
    //承运商查询地址获取
    public function getStationUrl($shipping_id){
        $out = $this->helper->get("carrierManage/getStationUrl/{$shipping_id}");
        return $out['get_station_url'];
    }
}
