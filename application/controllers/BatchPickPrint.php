<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class BatchPickPrint extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('batchPick');
	    $this->helper->chechActionList(array('batchPickPrint'),true);
	}

  public function index()
  {
     $this->load->view('batch_pick_print');
  }
  
  public function queryStatus(){
  	$batch_pick_sn = $this->input->post("batch_pick_sn");
  	$out = $this->batchPick->validateBatchPickPrinted($batch_pick_sn);
  	echo json_encode(array("status"=>$out));
  }
}
?>
