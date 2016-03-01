<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class CreateProductionBatch extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper');
	    $this->load->model("productionbatch");
	    $this->load->model('common');
	    $this->load->model('facility');
	    $this->helper->chechActionList(array('createproductionbatch'),true);
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			return $out;
		} else {
			$out = trim( $out );
		}
	
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}
	
  public function create(){
  	$facility_id = $this->getInput('facility_id');
  	if(!isset($facility_id)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'无法获取当前仓库' ) );
  		return false;
  	}
  	
	$cod = array(
  		'facility_id' => $facility_id,
  		'list' 		  => $this->input->post('list')
  	);
  	
  	$out = $this->productionbatch->createProductionBatch( $cod );
  	echo json_encode($out);
  }	
	
  public function index()
  {
	$cond = array();
	$data = $this->helper->merge($cond);
	$this->load->view('create_production_batch', $data);
  }
  public function getPickUpProductList(){
  	$facility_id = $this->getInput('facility_id');
  	$out = $this->productionbatch->getPickUpProductList( $facility_id );
	echo json_encode($out);
  }
  public function getPickUpProductDetail(){
  	$facility_id = $this->getInput('facility_id');
  	$product_id = $this->getInput('product_id');
  	$production_batch_type = $this->getInput('production_batch_type');
  	$out = $this->productionbatch->getPickUpProductDetail($facility_id,$product_id,$production_batch_type);
	echo json_encode($out);
  }
  
  private function getDetailListCond(){
  	$cond = array();
  	$production_batch_type = $this->getInput('production_batch_type');
  	if(!empty($production_batch_type)) {
  		$cond['production_batch_type'] = $production_batch_type;
  	}
  	
  	$status = $this->getInput('status');
  	if(isset($status)) {
  		$cond['status'] = $status;
  	}
  	
  	$facility_id = $this->getInput('facility_id');
  	if(!empty($facility_id)) {
  		$cond['facility_id'] = $facility_id;
  	}
  	
  	$production_batch_id = $this->getInput('production_batch_id');
  	if(!empty($production_batch_id)) {
  		$cond['production_batch_id'] = $production_batch_id;
  	}
  	
  	$is_shipping = $this->getInput('is_shipping');
  	if(isset($is_shipping)) {
  		$cond['is_shipping'] = $is_shipping;
  	}
  	$shipping_id = $this->input->get('shipping_id');
  	if(isset($shipping_id)) {
  		$cond['shipping_id'] = $shipping_id;
  	}
  	
  	$product_id = $this->getInput('product_id');
  	if(!empty($product_id) && $product_id != 'shipping_product_total' && $product_id != 'product_total' && $product_id != 'total') {
  		$cond['product_id'] = $product_id;
  	}
  	return $cond;
  }
  
  public function getShipmentDetailList() {
  	$cond = $this->getDetailListCond();
  	$out = $this->productionbatch->getShipmentDetailList($cond);
  	if($this->helper->isRestOk($out,'shipment_detail_list')){
  		$cond['shipment_detail_list'] = $out['shipment_detail_list'];
  	}
  	
  	$data = $this->helper->merge($cond);
  	$this->load->view('shipment_detail_list', $data);
  }

  public function orderIndex (){
    $cond = array();
    $data = $this->helper->merge($cond);
    $this->load->view('order_create_production_batch', $data);
  }

  public function getOrderIndex (){
    $cond = array();
    $out_order_sn = $this->input->get('out_order_sn');
    if(isset($out_order_sn)) {
      $cond['out_order_sn'] = $out_order_sn;
    }
    $out = $this->helper->get("/shipment/ShipmentInfo",$cond);
    echo json_encode($out);

  }
  public function orderCreateProductionBatch (){
    $cond = array();
    $facility_id = $this->input->post('facility_id');
    if(isset($facility_id)) {
      $cond['facility_id'] = $facility_id;
    }
    $shipment_ids = $this->input->post('shipment_ids');
    if(isset($shipment_ids)) {
      // $shipment_ids=implode(',',$shipment_ids);
      $cond['shipment_ids'] = $shipment_ids;
    }

    $out = $this->helper->post("/production/batch/created_by_shipment_ids",$cond);
    echo json_encode($out);
  }
}
?>