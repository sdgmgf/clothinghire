<?php

class addCarriage extends CI_Controller {

    private $error_info;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('helper');
        $this->load->model('common');
        $this->load->model('region');
        $this->load->model('facility');
        $this->load->model('carriage');
        $this->load->model('coverage');
        $this->helper->chechActionList(array('readCarriageFreight','editCarriageFreight'),true) ;
        
        $this->error_info = array(
            "facility_id" => "未选择仓库",
            "shipping_id" => "未选择快递",
            "first_fee" => "缺少首重快递费",
            "first_weight" => "缺少首重",
            "continued_fee" => "缺少续重快递费",
            "region_ids" => "未选择区域",
            "rule_id" => "未选择规则",
            "from_region_id" => "参数缺失请联系开发人员",
            "region_id" => "未选择区域",
            "region_type" => "区域级别未传递",
            "region_name" => "区域名称未传",
            "province_id" => "未设置省",
            "city_id" => "未设置市",
            "district_id" => "未设置区域"
        );
    }

    //<----------------------------功能开始----------------------------------------->
    //快递费用录入首页
    public function index() {
        $parent_id = $this->getInput('parent_id');
        $facility_id = $this->getInput('facility_id');
        $shipping_id = $this->getInput('shipping_id');
        if (empty($parent_id) || 1 == $parent_id) {
            //主页
            $out = $this->getAreaRegion();
            $result = array();
            foreach ($out['data'] as $key => $v) {
                $result[$v['area_name']][] = $v;
            }
            $data['area_list'] = $result;
            $data['local_id'] = 1;
        } else {
            //子页面
            $data = $this->getRegion($parent_id, $region_tpye = null);
            $data = $data['data'];
            $out = $this->getParentRegionId($parent_id);
            $data['parent_id'] = $out['region_id'];
        }
        $data['facility_list'] = $this->getAllFacility();
        $data['carriage_rule'] = $this->getCarriageRule();
        $facility_id && $data['facility_id'] = $facility_id;
        $shipping_id && $data['shipping_id'] = $shipping_id;
        $data = $this->helper->merge($data);
        $this->load->view('carriage.php', $data);
    }

    //<----------------------------上一个功能结束----------------------------------------->
    // --------------------------------------------------------------------
    //<----------------------------功能开始----------------------------------------->
    //获取区域及其子区域的快递费用
    public function getCarriageFreight() {
        $this->helper->chechActionList(array('readCarriageFreight'),true);
        $data = array();
        $out = $this->getCarriageFreightData();
        if (isset($out['error_info'])) {
            print_r(json_encode($out));
        } else {
            $data['data'] = $out;
            $data['region_name'] = $this->getInput('region_name');
            $data = $this->helper->merge($data);
            $this->load->view('carriage_freight', $data);
        }
    }

    //<----------------------------上一个功能结束----------------------------------------->
    //<----------------------------功能开始----------------------------------------->
    //快递规则页面显示需要子功能
    public function getShippings() {
        $facility_id = $this->getInput('facility_id');
        if (isset($facility_id)) {
            $out = $this->facility->getShipping($facility_id);
            $out['data'] = $out;
            print_r(json_encode($out));    
        }else{
            print_r(json_encode(array('error_info'=>$this->error_info['facility_id'])));
        }
        return;
    }

    private function getAllFacility() {
        $out = $this->common->getRealFacilityList();
        return $out['data']['list'];
    }

    private function getAreaRegion() {
        $result = $this->carriage->getAreaRegion();
        return $result;
    }

    private function getRegion($region_id, $region_type) {
        return $this->region->getRegion($region_id, $region_type);
    }

    private function getCarriageRule() {
        return $this->carriage->getCarriageRule();
    }

    private function getParentRegionId($region_id) {
        $cond = array();
        $cond['region_id'] = $region_id;
        return $this->carriage->getParentRegionId($cond);
    }

    //<----------------------------上一个功能结束----------------------------------------->
    //<----------------------------功能开始----------------------------------------->
    //新增时参数判断
    private function getAddCondition() {
        $cond = array();
        $cond['facility_id'] = $this->getInput('facility_id');
        $cond['shipping_id'] = $this->getInput('shipping_id');
        $cond['first_fee'] = $this->getInput('first_fee');
        $cond['first_weight'] = $this->getInput('first_weight');
        $cond['continued_fee'] = $this->getInput('continued_fee');
        $cond['region_ids'] = $this->getInput('region_ids');
        $cond['rule_id'] = $this->getInput('rule_id');
        $cond['from_region_id'] = $this->getInput('from_region_id');
        $cond['region_type'] = $this->getInput('region_type');
        return $this->checkParams($cond) ? $this->checkParams($cond) : $cond;
    }

    public function addNewCarriage() {
        $this->helper->chechActionList(array('editCarriageFreight'),true);
        $cond = $this->getAddCondition();
        if (isset($cond['error_info'])) {
            print_r(json_encode($cond));
        } else {
            $out = $this->carriage->addCarriage($cond);
            print_r(json_encode($out));
        }
    }

    //<----------------------------上一个功能结束----------------------------------------->
    //<----------------------------功能开始----------------------------------------->
    private function getCarriageFreightData() {
        $cond['facility_id'] = $this->getInput('facility_id');
        $cond['shipping_id'] = $this->getInput('shipping_id');
        $cond['region_id'] = $this->getInput('region_id');
        if ($result = $this->checkParams($cond)) {
            return $result;
        } else {
            $out = $this->carriage->getCarriageFreight($cond);
            return $out['data'];
        }
    }

    //<----------------------------上一个功能结束----------------------------------------->
    //<----------------------------公有函数----------------------------------------->
    private function checkParams($cond) {
        foreach ($cond as $key => $v) {
            if (empty($v)) {
                $result = array();
                $result['error_info'] = $this->error_info[$key];
                return $result;
            }
        }
    }

    private function getInput($name) {
        $out = trim($this->input->post($name));
        if (isset($out) && $out != "") {
            return $out;
        } else {
            $out = trim($this->input->get($name));
            if (isset($out) && $out != "")
                return $out;
        }
        return null;
    }

}
