<?php
class PinXiaoZhanOpenOrder extends CI_Controller {
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
        $cond = array();
        $data = $this->helper->merge($cond);
        $this->load->view('pinxiaozhan_open_order',$data);
     }

     public function getPinXiaoZhanDeatil() {
        $tracking_number = $this->getInput('tracking_number');
        $data = $this->Openorder->getPinXiaoZhanDeatil($tracking_number);
        echo json_encode($data);
     }

     public function signatureConfirmation() {
        $tracking_number = $this->getInput('tracking_number');
        $data = $this->Openorder->signatureConfirmation($tracking_number);
        echo json_encode($data);
     }

     public function BenbenCannotship() {
        $cond = array();
        $data = $this->helper->merge($cond);
        $this->load->view('benben_cannot_ship',$data);
     }

     public function showBenbenCannotship() {
        $cond = array();
        $data = $this->Openorder->showBenbenCannotship($cond);
        echo json_encode($data);
     }
}
?>
