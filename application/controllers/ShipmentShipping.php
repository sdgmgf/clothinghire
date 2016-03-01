<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ShipmentShipping extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('shipment');
	    $this->load->model('region');
	    $this->load->model('common');
	    $this->helper->chechActionList(array('batchPickDeliver'),true);
	}

  public function index($cond = array())
  {
  	
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
  public function printPage(){
  	$data = $this->helper->merge ( array() );
  	 $this->load->view('shipment_print',$data);
  }
  public function validatePrint(){
  	 $tracking_number = $this->getInput('tracking_number');
	 $out = $this->shipment->validateShipmentCanPrint ($tracking_number);
	 echo json_encode($out);
	 
  }
  public function doPrint(){
	 $shipment_id = $this->getInput('shipment_id');
	 $cond = $this->shipment->getShipmentPrintData ($shipment_id);
	 
	 if(isset($cond['error_info']) && !empty($cond['error_info'])){
//	 	 var_dump($cond);
	 	$cond ['webRoot'] = $this->helper->getUrl ();
		$data = $this->helper->merge ( $cond );
		$this->load->view ( 'shipment_print', $data );
	 }else{
//	 	var_dump($cond);
	 	$cond ['webRoot'] = $this->helper->getUrl ();
	 	$cond ['from_page'] = "printPage";
		$data = $this->helper->merge ( $cond );
		$this->load->view ( 'print_action', $data );
	 }
  }
  public function shipPage(){
  	 $this->load->view('shipment_ship',array ());
  }
  public function shipPageWithWeight(){
  	$this->load->view('shipment_ship_with_weight',array ());
  }
  public function doShip(){
  	 $tracking_number = $this->getInput('tracking_number');
  	 $out = $this->shipment->shipShipment ( $tracking_number);
  	 $out['tracking_number'] = $tracking_number;
	 echo json_encode(isset($out) ? $out : array());
  }
  public function doShipWithWeight(){
  	 $tracking_number = $this->getInput('tracking_number');
  	 $weight = $this->getInput('weight');
  	 $out = $this->shipment->shipShipmentWithWeight ($tracking_number,$weight);
  	 $out['tracking_number'] = $tracking_number;
	 echo json_encode(isset($out) ? $out : array());
  }
}
?>