<?php

class Pallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Helper');       
        $this->load->model('common');
        $this->load->model('Palletmodel');
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

    private function getConditionByarr($arr){
        $cond = array();
        foreach ($arr as $key => $value) {
            $temp = $this->getInput($value);
            if( isset($temp) ){
                $cond[$value] = $temp;
            }
        }
        return $cond;
    }

    public function getFacilityList(){
        $facility_list = $this->common->getFacilityList();    
        if( !empty($facility_list)) {
            return $facility_list['data'];
        }
    }

    public function palletList(){
        $cond = $this->getConditionByarr( array('facility_id','start_time','end_time') );
        $facility_list = $this->getFacilityList();
        if(!empty($facility_list)){
            $cond['facility_list'] = $facility_list;
        }
        if( empty($cond['facility_id']) && !empty($facility_list[0]) ){
            $cond['facility_id'] = $facility_list[0]['facility_id'];
        }
        $pallet_list = $this->Palletmodel->getPalletList($cond);
        if($this->helper->isRestOk($pallet_list)){
            $cond['pallet_list'] = $pallet_list;
        }
        $data = $this->helper->merge($cond);
        $this->load->view('pallet_list',$data);
    }

}
