<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PrintOrderList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model('order');
	    $this->load->model('productmodel');
	    $this->load->model('batchpick');
	    $this->load->model('region');
	    $this->load->model('common');
	    $this->load->model('shipping_template_model');
	    $this->helper->chechActionList(array('printOrderList'),true);
	}

  public function index($cond = array())
  {
      $facility_list = $this->common->getFacilityList();
      if(count($facility_list['data']) > 1){
      	echo "您有多个仓的权限，不能打单！";
      	die(0);
      }else{
      	if(empty($cond['facility_id']) && !empty($facility_list['data'][0]['facility_id'])){
      		$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
      		$cond['facility_name'] = $facility_list['data'][0]['facility_name'];
      	} else {
      		$cond['facility_id'] = 0;
      	}
      }
      $province_list = $this->common->getProvinceByFacility($cond['facility_id']);
      
      
      $shipping_list = $this->shipping_template_model->getShippingByFacility($cond['facility_id']);
      if(empty($cond['$shipping_id']) && !empty($shipping_list['shipping'][0]['shipping_id']))
      {
      	$cond['shipping_id'] = $shipping_list['shipping'][0]['shipping_id'];
      }
      
      $product_list = $this->productmodel->productListForPrint($cond);
      
      $cond['province_list'] = isset($province_list) ? $province_list : array();
      $cond['product_list'] = $product_list;
      
      //站点列表
      if(isset($cond['facility_id']) && isset($cond['shipping_id'])){
      	$station_list = $this->region->getStationList($cond['facility_id'],$cond['shipping_id']);
      	$cond['station_list'] = $station_list['data'];
      }
      
      $cond['shipping_list'] = $shipping_list;
      $data = $this->helper->merge($cond); 
      $this->load->view('print_order_list',$data);
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

   // 获取前端 post 传递过来的查询条件
   private function getQueryCondition( ){
      $cond = array( );  
      $cond['status'] = "1";
      $cond['order_type'] = "0";
      
      $shipping_id = $this->getInput('shipping_id');
      if (isset($shipping_id) && $shipping_id) {
      	$cond['shipping_id'] = $shipping_id;
      }
      
      
      $facility_id = $this->getInput('facility_id');
      if (isset($facility_id) && $facility_id) {
      	$cond['facility_id'] = $facility_id;
      } else {
      	die('没有选择仓库');
      }
      
      $facility_name = $this->getInput('facility_name');
      if(isset($facility_name) && $facility_name){
      	$cond['facility_name'] = $facility_name;
      }
      
      $print_order_id = $this->getInput('print_order_id');
      if(isset($print_order_id) && $print_order_id){
        $cond['shipment_id'] = $print_order_id;
      } 
     
      $product_id = $this->getInput('product_id');
      if(isset($product_id) && $product_id != 'all' ){
        $cond['product_id'] = $product_id;
      } 

      $order_count = $this->getInput('order_count');
      if(isset($order_count) ){
        $cond['order_count'] = $order_count;
      } 
      
      $start_time = $this->getInput('start_time');
      if(isset($start_time) ){
        $cond['success_time_start'] = $start_time;
      } 
      
      $end_time = $this->getInput('end_time');
      if(isset($end_time) ){
        $cond['success_time_end'] = $end_time;
      } 
      
      $province_id = $this->getInput('province_id');
      if(isset($province_id) && $province_id != 'all'){
        $cond['province_id'] = $province_id;
      } 
      
      $city_id = $this->getInput('city_id');
      if(isset($city_id) && $city_id != 'all'){
        $cond['city_id'] = $city_id;
      }
      
      $address_name = $this->getInput('address_name');
      if(isset($address_name)){
      	$cond['address_name'] = $address_name;
      }
      
      $address_type = $this->getInput('address_type');
      if(isset($address_type)){
        $cond['address_type'] = $address_type;
      }

      $district_id = $this->getInput('district_id');
      if(isset($district_id)){
      	$cond['district_id'] = $district_id;
      }
      
      $station_no = $this->getInput('station_no');
      if(isset($station_no)){
      	$cond['station_no'] = $station_no;
      }

      $out_order_sn = $this->getInput('out_order_sn');
      if(isset($out_order_sn)){
        $cond['out_order_sn'] = $out_order_sn;
      }
      
      return $cond;
   }


   // 查询得到订单列表  
  public function query(){
      $cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端 
      if(!empty($cond['facility_id']) && !empty($cond['product_id']) && !empty($cond['shipping_id'])){
      	$out = $this->order->getOrderPrintList($cond);
      } else {
      	$out['error_info'] = '仓库，商品，快递方式必填';
      }
      
      $province_list = $this->common->getProvinceByFacility($cond['facility_id']);
      $shipping_list = $this->shipping_template_model->getShippingByFacility($cond['facility_id']);
      $product_list = $this->productmodel->productListForPrint($cond);
      if(!isset($out['data'])){  // 调用 api 出现错误
      	$con['error_info'] = $out['error_info'];
      }else{  //  调用 API 成功
      	$order_list =  $out['data']['order_list'] ;
      	$cond['order_list'] = $order_list;
      }
      $cond['product_list'] = $product_list;
//       $cond['province_list'] = isset($province_list) ? $province_list : array();

	  $cond['province_list'] = isset($province_list) ? $province_list : array();
      $cond['webRoot'] = $this->helper->getUrl();
      
      $facility_list = $this->common->getFacilityList();
      if (isset($facility_list['error_info'])) {
          $cond['facility_list'] = array();
      } else {
	      $cond['facility_list'] = $facility_list['data'];
      }
      $cond['shipping_list'] = $shipping_list;
      
      //站点列表
      if(isset($cond['facility_id']) && isset($cond['shipping_id'])){
      	$station_list = $this->region->getStationList($cond['facility_id'],$cond['shipping_id']);
      	$cond['station_list'] = $station_list['data'];
      }
       // 把数据 和 系统信息 合并后放到视图中 
      $data = $this->helper->merge($cond);
	 $this->load->view('print_order_list',$data);
  }                                   // query  end
  public function createBatchPick(){
	  $product_id = $this->input->post('select_product_id');
	  $shipping_id = $this->input->post('select_shipping_id');
	  $facility_id = $this->input->post('select_facility_id');
	  $address_name = $this->input->post('select_address_name');
	  $shipment_ids = $this->input->post('shipmentIds');
	  ini_set('date.timezone','Asia/Shanghai');
	 if (date('N') == 4 && empty($address_name)) {
	 	$cond['message'] = "失败，星期四必须选择公司或家庭";
	 	$this->index($cond);
	 } else {
		 $result = $this->batchpick->createBatchPick($product_id,$shipping_id,$facility_id,$shipment_ids);
		 if (!$result || isset($result['error_info'])) {
		 	$cond['message'] = $result['error_info'];
		 	 $this->index($cond);
		 } else {
		  	$cond['order'] = $result['data']['batch_info'];
		  	$cond['sn_code_img'] = $this->helper->getUrl() . "codeImg?barcode="  . $result['data']['batch_info']['batch_pick_sn'] . "&height=80&width=500&text=0";
		  	$cond['min_code_img'] = $this->helper->getUrl() . "codeImg?barcode=" . $result['data']['batch_info']['min_order']['tracking_number'] . "&height=80&width=500&text=0";
		  	$cond['max_code_img'] = $this->helper->getUrl() . "codeImg?barcode=" . $result['data']['batch_info']['max_order']['tracking_number'] .  "&height=80&width=500&text=0";
		  	$data = $this->helper->merge($cond); 
		  	$this->load->view('batch_print', $data);
		}
	 }
  }
    
  public function shippingProduct(){
  	$shipping_id = $this->getInput('shipping_id');
  	$facility_id = $this->getInput('facility_id');
  	$cond['shipping_id'] = $shipping_id;
  	$cond['facility_id'] = $facility_id;
  	$product_list = $this->productmodel->productListForPrint($cond);
  	echo json_encode(isset($product_list['product']) ? $product_list['product'] : array());
  } 
  
  public function facilityShipping() {
  	$facility_id = $this->getInput('facility_id');
  	$shipping_list = $this->shipping_template_model->getShippingByFacility($facility_id);
  	$province_list = $this->common->getProvinceByFacility($facility_id);
  	$result = array();
  	if(isset($shipping_list['shipping'])){
  		$result['shipping'] = $shipping_list['shipping'];
  	}
  	if(isset($province_list)){
  		$result['province_list'] = $province_list;
  	}
  	
  	echo json_encode($result);
  }
  
  public  function cityList(){
  	$province_id = $this->getInput('province_id');
  	$city_list = $this->region->getRegion($province_id, 2);
  	echo json_encode(isset($city_list['data']) ? $city_list['data'] : array());
  }
  
}
?>
