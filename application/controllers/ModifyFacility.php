<?php
class ModifyFacility extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('Helper');
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('facility');
		$this->load->model('region');
		$this->load->model('shipping_template_model');
	}
	
	public function viewModifyShipping() {
		$area_list = $this->common->getAreaList();
	  	if(empty($data['area_id']) && !empty($area_list['data'][0]['area_id'])){
	  		$data['area_id'] = $area_list['data'][0]['area_id'];
	  	}
		if (isset($area_list['error_info'])) {
			$data['area_list'] = array();
		} else {
			if(isset($area_list['data'])){
				$data['area_list'] = $area_list['data'];
			}
		}
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)){
			$data['facility_id'] = $facility_id ;
		}else{
			$data['facility_id'] = '';
		}
		//根据facility_id查找出所有快递方式

		// $out = $this->facility->getShipping($facility_id);
		// $data = $out['data'];

		//获取快递方式
		// $shipping_list = $this->shipping_template_model->getAllShipping();
		// $data['shipping_list'] = $shipping_list;
		$data = $this->helper->merge($data);
		$this->load->view('modify_facility_shipping',$data);
	}
	public function getShippingList(){
		//获取快递方式
		$shipping_list = $this->shipping_template_model->getAllShipping();
		echo json_encode($shipping_list);

	}

	public function getShipping(){
		$facility_id = $this->getInput('facility_id');
		$out = $this->facility->getShipping($facility_id);
		echo json_encode($out);
	}

	public function getFacilityShippingCoverageArea(){
		$facility_id = $this->getInput('facility_id');
		$shipping_id = $this->getInput('shipping_id');
		$out = $this->facility->getFacilityShippingCoverageArea($facility_id,$shipping_id);
		echo json_encode($out);
	}

	public function addFacilityShippingCoverageArea(){
		$cond = array();
		$facility_id = $this->getInput('facility_id');
		$shipping_id = $this->getInput('shipping_id');
		$cond['area_ids'] = $this->getInput('area_ids');
		$out = $this->facility->addFacilityShippingCoverageArea($facility_id,$shipping_id,$cond);
		echo json_encode($out);
	}

	//提交修改数据
	public function modifyFacilityShippingAbility() {
		$facility_shipping_id = $this->input->post("facility_shipping_id");
	    if(isset($facility_shipping_id)){
	    	$cond['facility_shipping_id'] = $facility_shipping_id;
	    } else{
	    	$cond['facility_shipping_id'] = '';
	    }
	    $start_pickup_time = $this->input->post("start_pickup_time");
	    if(isset($start_pickup_time)){
	    	$cond['start_pickup_time'] = $start_pickup_time;
	    } else{
	    	$cond['start_pickup_time'] = '';
	    }
	    $end_pickup_time = $this->input->post("end_pickup_time");
	    if(isset($end_pickup_time)){
	    	$cond['end_pickup_time'] = $end_pickup_time;
	    } else{
	    	$cond['end_pickup_time'] = '';
	    }
	    $pickup_upper_limit = $this->input->post("pickup_upper_limit");
	    if(isset($pickup_upper_limit)){
	    	$cond['pickup_upper_limit'] = $pickup_upper_limit;
	    } else{
	    	$cond['pickup_upper_limit'] = '';
	    }
	    $out = $this->helper->post("/facility/updateShipping",$cond);
	    echo json_encode($out);


	}
	
	public function viewModifyProducts() {
		$facility_id = $this->getInput('facility_id');
		$out = $this->facility->getAvaiableProduct($facility_id);
		$data = $out['data'];
		$out = $this->facility->getAreaByFacility($facility_id);
		if(!isset($out['merchant_id'])){
			echo "该仓库未绑定 店铺 和 区域";die();
		}
		$merchant_id = $out['merchant_id'];
		$data['merchant_id'] = $merchant_id;
		$data['merchant_name'] = $out['merchant_name'];
		
		$data = $this->helper->merge($data);
		$this->load->view('modify_facility_product',$data);
	}
	
	public function addFacilityShipping() {
		$data = array(
			"facility_id" => $this->input->post('facility_id'),
			"shipping_id" => $this->input->post("shipping_id"),
			"facility_shipping_user" => $this->input->post("user"),
			"facility_shipping_password" => $this->input->post("password"),
			"sf_account" => $this->input->post("account"),
			"area_ids" => $this->input->post("area_ids")
		);
// 		var_dump($data);die();
		$info = $this->facility->addFacilityShipping($data);
		
		echo json_encode($info);
	}

	public function closeFacilityShipping() {
		$facility_shipping_id = $this->input->post('facility_shipping_id');
		$info = $this->facility->closeFacilityShipping($facility_shipping_id);
		echo json_encode($info);
	}
	
	public function enableFacilityShipping() {
		$facility_shipping_id = $this->input->post('facility_shipping_id');
		$info = $this->facility->enableFacilityShipping($facility_shipping_id);
		echo json_encode($info);
	}
	
	public function addFacilityProduct(){
		$product_id = $this->getInput("product_id");
		$facility_id = $this->getInput("facility_id");
		
		$info = $this->facility->addFacilityProduct($facility_id,$product_id);
		echo json_encode($info);
	}
	public function deleteFacilityProduct(){
		$product_id = $this->getInput("product_id");
		$facility_id = $this->getInput("facility_id");
		
		$info = $this->facility->deleteFacilityProduct($facility_id,$product_id);
		echo json_encode($info);
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if (!is_array($out)) {
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
	public function facilityWithoutShipping(){
		$data = array();
		$out = $this->facility->getFacilityInfoList();
		$data['facility_list'] = $out['data']['facility_info_list'];
		$data['WEB_ROOT'] = $this->helper->getUrl();
		$this->load->view('no_region_shipping',$data);
	}
	
	public function getFacilityWithoutRegionShipping(){
		$facility_id = $this->input->get('facility_id');
		
		$data = array();
		if(!empty($facility_id))
			$data = $this->facility->getProductRegionWithoutShipping($facility_id);
		
		$this->load->view('no_region_shipping_sect',$data);
	}
	
	public function checkUser() {
		$shipping_id = $this->input->post("shipping_id");
		$user = $this->input->post("user");
		$pwd = $this->input->post("password");
		$sf_account = $this->input->post("account");
		if($shipping_id != 44 || $shipping_id != 45)
			$sf_account = null;
	
		$res = $this->get_express_tracking_number($shipping_id, $user, $pwd, $sf_account);
// 		 		print_r($res);var_dump($res['result'] === true);die();
		if(empty($res)){
			echo json_encode(array("success"=>"false", "info"=>"未获取到快递账号信息"));die();
		}
		if((array_key_exists('is_ok', $res) && $res['is_ok'] === true) 
				|| (array_key_exists('result', $res) && $res['result'] == 'true')){
			if(array_key_exists('tracking_number', $res)){
				$tn = ((array)$res['tracking_number']);
				echo json_encode(array("success"=>"true","tn"=>$tn[0]));
			}else if(array_key_exists('list', $res)){
				$tn = ($res['list']);
				echo json_encode(array("success"=>"true","tn"=>$tn[0]));
			}
			else 
				echo json_encode(array("success"=>"true","tn"=>""));
		}else if(array_key_exists('remark', $res)){
			echo json_encode(array("success"=>"false","info"=>$res['remark']));
		}else if (array_key_exists('error', $res)){
			$error_info = (array)$res['error'];
			echo json_encode(array("success"=>"false","info"=>$error_info[0]));
		}else{
			echo json_encode(array("success"=>"false"));
		}
	}
	
	public function checkShippingUser(){
		$facility_shipping_id = $this->input->post("facility_shipping_id");
		$record = $this->facility->getFacilityShippingById(array("facility_shipping_id"=>$facility_shipping_id));
		
		if(empty($record))
			echo json_encode(array("success"=>"false","info"=>"记录不存在"));
		else{
			$account = null;
			if($account == 44 || $account == 45){
				if(!empty($record['sf_account']))
					$account = $record['sf_account'];
				else{
					echo json_encode(array("success"=>"false","info"=>"顺丰，无月结账号"));die();
				}
			}
// 			var_dump($record);die();
			$res = $this->get_express_tracking_number($record['shipping_id'], $record['facility_shipping_user'], $record['facility_shipping_password'], $account);
// 			var_dump($res);die();
			if(empty($res)){
				echo json_encode(array("success"=>"false", "info"=>"未获取到快递账号信息"));die();
			}
			if((array_key_exists('is_ok', $res) && $res['is_ok'] === true)
					|| (array_key_exists('result', $res)&& $res['result'] == 'true')){
				if(array_key_exists('tracking_number', $res)){
					$tn = ((array)$res['tracking_number']);
					echo json_encode(array("success"=>"true","tn"=>$tn[0]));
				}else if(array_key_exists('list', $res)){
					$tn = ($res['list']);
					echo json_encode(array("success"=>"true","tn"=>$tn[0]));
				}
				else 
					echo json_encode(array("success"=>"true","tn"=>""));
			}else if(array_key_exists('remark', $res)){
				echo json_encode(array("success"=>"false","info"=>$res['remark']));
			}else if (array_key_exists('error', $res)){
				$error_info = (array)$res['error'];
				echo json_encode(array("success"=>"false","info"=>$error_info[0]));
			}else{
				echo json_encode(array("success"=>"false"));
			}
		}
	}
	
	private function get_express_tracking_number($shipping_id,$user,$pwd,$sf_account){
		$product = array();
		$product[0]['product_name'] = '水果';
		$product[0]['product_number'] = 1;
	
		$order =  array (
				'receive_name' 	=> '拼好货商城',
				'tel' 		=> '400-067-1217',
				'mobile' 	=> '187****9611',
				'province_name' => '浙江',
				'city_name' 	=> '嘉兴',
				'district_name' => '南湖区',
				'shipping_address' 	=> '欧嘉路明新路交叉口，大头水果包装厂',
				'product_name'=>'水果'
		);
		$order['order_sn'] = 'Test'.date('YmdHis'). str_pad((mt_rand(1, 99999)), 6, '0', STR_PAD_LEFT);
		$shop = array (
				'SHOP_NAME' 	=> '拼好货商城',
				'SHOP_TEL' 		=> '400-067-1217',
				'SHOP_MOBILE' 	=> '',
				'SHOP_PROVINCE' => '浙江',
				'SHOP_CITY' 	=> '嘉兴',
				'SHOP_DISTRICT' => '南湖区',
				'SHOP_ADDRESS' 	=> '欧嘉路明新路交叉口，大头水果包装厂',
				'SHOP_POSTCODE' => '314001'
		);
	
		$account['USER']= $user;
		$account['PASSWORD'] = $pwd;
		$account['ACCOUNT'] = $sf_account;
	
		if($shipping_id == 44 || $shipping_id == 45){
			$account['URL'] = 'http://210.21.231.12/bsp-oisp/ws/sfexpressService?wsdl';
			return $this->test_sf_account($order,$product,$shop,$account);
		}else if($shipping_id == 84 || $shipping_id == 85){
			$account['URL'] = 'http://service.yto56.net.cn/CommonOrderModeBServlet.action';
			return $this->test_yt_account($order,$product,$shop,$account);
		}else if($shipping_id == 115){
			$account['URL'] = 'http://partner.zto.cn/partner/interface.php';
				
			return $this->test_zt_account($order,$product,$shop,$account);
		}else if($shipping_id == 3){
			$account['URL'] = 'http://ebill.ns.800best.com/ems/api/process';
			// 			var_dump($account);die();
			return $this->test_ht_account($order,$product,$shop,$account);
		}else if($shipping_id == 4){
			$account['URL'] = 'http://order.yundasys.com:10235';
			// 			var_dump($account);die();
			return $this->test_yd_account($order,$shop,$account);
        } else if($shipping_id == 5){
            $account['URL'] = 'http://api.ttk.cn:22220/InterfacePlatform/ApiService';
            $order['order_sn'] = "testphh-01";
            return $this->test_ttkd_account($order,$product,$shop,$account);
        }
	}
	
	private function test_yd_account($order,$shop,$account){
		$result = array();
		$result['is_ok'] = true;
		try {
	        $shipment = $this->yd_apply_order($shop, $order, $account['USER'], $account['PASSWORD'],$account['URL']);
			if($shipment['is_ok']){
				$result['tracking_number'] = $shipment['tracking_number'];
				
			}else{
				$result['is_ok'] = false;
	            $result['error'] = $shipment['msg'];
			}
	    } catch(Exception $e) {
	        $result['is_ok'] = false;
	        $result['error'] = $e->getMessage();
	    }
		return $result;
	}
	private function yd_apply_order($shop, $order,$user,$pw,$url){
		$url_detail = '/cus_order/order_interface/interface_receive_order__mailno.php';
		$content = $this->get_yt_content_xml($shop,$order);
		$res = $this->get_yd_response('data',$content,$user,$pw,$url.$url_detail);
		$res_xml = simplexml_load_string($res);
		$result['is_ok'] = (string)$res_xml->response->status;
		$result['msg']  = (string)$res_xml->response->msg;
		if($result['is_ok']){
			$result['tracking_number'] = (string)$res_xml->response->mail_no;
			$pdf_info = $res_xml->response->pdf_info;
			$pdf_info_json = json_decode($pdf_info);
			$pdf_detail = $pdf_info_json['0']['0'];
			$result['package'] = $pdf_detail->package_wdjc;
			$result['package_no'] = $pdf_detail->package_wd;
			$result['station'] = $pdf_detail->position;
			$result['station_no'] = $pdf_detail->position_no;
			$result['sender_branch_no'] = $pdf_detail->sender_branch;
			$result['sender_branch'] = $pdf_detail->sender_branch_jc;
		}
		return $result;
	}
	private function get_yd_response($func,$content,$user,$pw,$url){ 
		$data = array(
		    'version'=>'1.0',
		    'request'=>$func,
		    'partnerid'=>$user,
		    'datetime'=>date("Y-m-d H:i:s"),
		    'validation'=>'',
		    'xmldata'=>base64_encode($content)
		);
		$data['validation'] = md5($data['xmldata'].$data['partnerid'].$pw);
		return $this->post_data($url,$data);
	}

			        
	private function get_yt_content_xml($sender,$order){
		$address = $order['province_name'].','.$order['city_name'].','.$order['district_name'];
		$sender_address = $sender['SHOP_PROVINCE'].','.$sender['SHOP_CITY'].','.$sender['SHOP_DISTRICT'];
		$res = "<orders>".
				"<order>".
					"<order_serial_no>".$order['order_sn']."</order_serial_no>".
					"<khddh>".$order['order_sn']."</khddh>".
					"<order_type>common</order_type>".
					"<sender>".
						"<name>".$sender['SHOP_NAME']."</name>".
						"<company>".$sender['SHOP_NAME']."</company>".
						"<city>".$sender_address."</city>".
						"<address>".$sender_address.$sender['SHOP_ADDRESS']."</address>".
						"<phone>".$sender['SHOP_TEL']."</phone>".
					"</sender>".
					"<receiver>".
						"<name>".$order['receive_name']."</name>".
						"<city>".$address."</city>".
						"<address>".$address.$order['shipping_address']."</address>".
						"<mobile>".$order['mobile']."</mobile>".
					"</receiver>".
				"</order>".
			"</orders>";
		return $res;
	}
	
	private function test_ht_account($order,$product,$shop,$account){
	
		$result = array();
		$result['is_ok'] = true;
		try {
			$res = $this->ht_apply_order($shop,$order,$product,$account['USER'],$account['PASSWORD'],$account['URL']);
		} catch(Exception $e) {
			$result['is_ok'] = false;
			$result['reason'] = 'Exception';
			$result['error'] = $e->getMessage();
			return $result;
		}
		$ship_result = simplexml_load_string($res);
		if($ship_result->result != "SUCCESS") {
			$result['is_ok'] = false;
			if( $ship_result->reason == 'S02'){
				$result['reason'] = 'ACCOUNT';
			}else{
				$result['reason'] = 'OTHER';
			}
				
			$result['error'] = $res;
			return $result;
		}
	
		$result['tracking_number'] = $ship_result->EDIPrintDetailList->mailNo;
		return $result;
	}
	
	private function ht_apply_order($shop,$order,$product,$partner_id,$partner_key,$url){
		$sendMan 		= $shop['SHOP_NAME'];
		$sendManPhone 	= $shop['SHOP_TEL'];
		$sendProvince 	= $shop['SHOP_PROVINCE'];
		$sendCity 		= $shop['SHOP_CITY'];
		$sendCounty 	= $shop['SHOP_DISTRICT'];
		$sendManAddress = $shop['SHOP_ADDRESS'];
	
		$receiveMan			= $order['receive_name'];
		$receiveManPhone	= $order['mobile'];
		$receiveManAddress	= $order['shipping_address'];
		$receiveProvince	= $order['province_name'];
		$receiveCity		= $order['city_name'];
		$receiveCounty		= $order['district_name'];
	
	
		$xml = '<?xml version="1.0" encoding="utf-8"?>'.
				'<PrintRequest xmlns:ems="http://express.800best.com">'.
				'<deliveryConfirm>true</deliveryConfirm>'.
				'<EDIPrintDetailList>'.
				'<sendMan>'.$sendMan.'</sendMan>'.
				'<sendManPhone>'.$sendManPhone.'</sendManPhone>'.
				'<sendManAddress>'.$sendManAddress.'</sendManAddress>'.
				'<sendProvince>'.$sendProvince.'</sendProvince>'.
				'<sendCity>'.$sendCity.'</sendCity>'.
				'<sendCounty>'.$sendCounty.'</sendCounty>'.
				'<receiveMan>'.$receiveMan.'</receiveMan>'.
				'<receiveManPhone>'.$receiveManPhone.'</receiveManPhone>'.
				'<receiveManAddress>'.$receiveManAddress.'</receiveManAddress>'.
				'<receiveProvince>'.$receiveProvince.'</receiveProvince>'.
				'<receiveCity>'.$receiveCity.'</receiveCity>'.
				'<receiveCounty>'.$receiveCounty.'</receiveCounty>'.
				'<txLogisticID>'.$order['order_sn'].'</txLogisticID>'.
				'<itemName>'.$product[0]['product_name'].'</itemName>'.
				'<itemCount>'.$product[0]['product_number'].'</itemCount>'.
				'</EDIPrintDetailList>'.
				'</PrintRequest>';
		$digest=base64_encode(md5($xml.$partner_key,true));
		$data=array(
				'bizData'	 => $xml,
				'serviceType'=> 'BillPrintRequest',
				'parternID'  => $partner_id,
				'digest'	 => $digest,
				'msgId'		 => uniqid('HT_Arata'),
		);
		$response=HttpClient::quickPost($url,$data);
		return $response;
	}
	
	private function test_yt_account($order,$product,$shop,$account){
		$result = array();
		$result['is_ok'] = true;
		try {
			$res = $this->shipYTOrderNew($account,$shop, $order, $product);
		} catch(Exception $e) {
			$result['is_ok'] = false;
			$result['reason'] = 'Exception';
			$result['error'] = $e->getMessage();
			return $result;
		}
	
		$ship_result = simplexml_load_string($res);
	
		if(empty($ship_result) || $ship_result->success == "false") {
			$result['is_ok'] = false;
			if( $ship_result->reason == 'S02'){
				$result['reason'] = 'ACCOUNT';
			}else{
				$result['reason'] = 'OTHER';
			}
				
			$result['error'] = $ship_result->reason;
	
			return $result;
		}
		$result['tracking_number'] = $ship_result->orderMessage->mailNo;
	
		return $result;
	}
	
	private function shipYTOrderNew($account,$shop, $order, $products){
	
		$string = "<RequestOrder>";
		$string  .= "<clientID>".$account['USER']."</clientID>";
		$string  .= "<logisticProviderID>YTO</logisticProviderID>";
		$string  .= "<customerId>".$account['USER']."</customerId>";
		$string  .= "<txLogisticID>".$order['order_sn']."</txLogisticID>";
		$string  .= "<tradeNo></tradeNo>";
		$string  .= "<totalServiceFee>0</totalServiceFee>";
		$string  .= "<codSplitFee>0</codSplitFee>";
		$string  .= "<orderType>1</orderType>";
		$string  .= "<serviceType>0</serviceType>";
		$string  .= "<flag>1</flag>";
		$string  .= "<sender>";
		$string  .= "<name>".$shop['SHOP_NAME']."</name>";
		$string  .= "<postCode>".$shop['SHOP_POSTCODE']."</postCode>";
		$string  .= "<phone>".$shop['SHOP_TEL']."</phone>";
		$string  .= "<mobile>".$shop['SHOP_MOBILE']."</mobile>";
		$string  .= "<prov>".$shop['SHOP_PROVINCE']."</prov>";
		$string  .= "<city>".$shop['SHOP_CITY'].",".$shop['SHOP_DISTRICT']."</city>";
		$string  .= "<address>".$shop['SHOP_ADDRESS']."</address>";
		$string  .= "</sender>";
		$string  .= "<receiver>";
		$string  .= "<name>".$order['receive_name']."</name>";
		$string  .= "<postCode>0</postCode>";
		$string  .= "<phone>".$order['mobile']."</phone>";
		$string  .= "<prov>".$order['province_name']."</prov>";
		$string  .= "<city>".$order['city_name'].",".$order['district_name']."</city>";
		$string  .= "<address>".$order['shipping_address']."</address>";
		$string  .= "</receiver>";
		$string  .= "<sendStartTime></sendStartTime>";
		$string  .= "<sendEndTime></sendEndTime>";
		$string  .= "<goodsValue>0</goodsValue>";
		$string  .= "<itemsValue>0</itemsValue>";
		$string  .= "<items>";
	
		foreach ($products as $product){
			$product_name = $product['product_name'];
			$string  .= "<item>";
			$string  .= "<itemName>".$product_name."</itemName>";
			$string  .= "<number>".$product['product_number']."</number>";
			$string  .= "<itemValue>0</itemValue>";
			$string  .= "</item>";
		}
	
		$string  .= "</items>";
		$string  .= "<insuranceValue>0</insuranceValue>";
		$string  .= "<special>0</special>";
		$string  .= "<remark>0</remark>";
		$string  .= "</RequestOrder>";
	
		$data_digest= base64_encode(Bytes::toStr(Bytes::getBytes(md5($string.$account['PASSWORD'],true))));
	
		$data=array();
		$data['logistics_interface']=$string;//urlencode();
		$data['data_digest']=($data_digest);
		$data['clientId']=$account['USER'];
	
		return $this->post_data($account['URL'],$data);
	}
    
    private function test_ttkd_account($order, $product, $shop, $account){
		$result = array();
		$result['is_ok'] = true;
		try {
			$res = $this->shipTTKDOrderNew($account, $shop, $order);
		} catch(Exception $e) {
			$result['is_ok'] = false;
			$result['reason'] = 'Exception';
			$result['error'] = $e->getMessage();
			return $result;
		}
		$ship_result = json_decode($res,true);
		if(empty($ship_result) || $ship_result['code'] != "1000") {
			$result['is_ok'] = false;
			$result['error'] = $ship_result['message'];
			return $result;
		}
        
		$result['tracking_number'] = $ship_result['mailNo'];
		return $result;
	}
    
    private function shipTTKDOrderNew($account,$shop, $order){
        $appKey = "YQPHH";
        $appScert = "OrwIR4HRL9";
        $serviceCode = "Waybill_OrderPush";
		$data = array(
            'site'=>"嘉兴", 
            'cus'=>$account['USER'],
            'password'=>$account['PASSWORD'],
            'checkDelivery'=>false,
            'isReturnDatoubi'=>true,
            'isReturnBillcode'=>true,
            'billcodeType'=>'VIP空白运单',
            'data'=>array(
                'txLogisticID'=>$order['order_sn'],
                'ecCompanyId'=>'YQPHH',
                'codSplitFee'=>'',
                'buyServiceFee'=>'',
                'orderType'=>1,
                'serviceType'=>0,
                'remark'=>'',
                'sender'=>array(
                    'name'=>$shop['SHOP_NAME'],
                    'phone'=>$shop['SHOP_TEL'],
                    'mobile'=>$shop['SHOP_MOBILE'],
                    'prov'=>$shop['SHOP_PROVINCE'],
                    'city'=>$shop['SHOP_CITY'],
                    'area'=>$shop['SHOP_DISTRICT'],
                    'address'=>$shop['SHOP_ADDRESS'],
                ),
                'receiver'=>array(
                    'name'=>$order['receive_name'],
                    'phone'=>$order['mobile'],
                    'mobile'=>$order['mobile'],
                    'prov'=>$order['province_name'],
                    'city'=>$order['city_name'],
                    'area'=>$order['district_name'],
                    'address'=>$order['shipping_address'],
                 ),
            ) 
        );
        $timestamp = time();
        $params = json_encode($data); 
        $content=$appKey.$serviceCode.$params.$timestamp.$appScert;
        $md5Str=md5($content);
        $digest=base64_encode($md5Str);
        $url = $account['URL'];
        $url .= "?digest=".$digest;
        $url .= "&params=".json_encode($data);
        $url .= "&appKey=".$appKey;
        $url .= "&serviceCode=".$serviceCode;
        $url .= "&timestamp=".$timestamp;
        $ret = $this->post_json_data($url, "");
        return $ret;
    }
	
	private function test_sf_account($order,$product,$shop,$account){
		$result = array();
		$result['is_ok'] = true;
		$shop['account_no'] = $account['ACCOUNT'];
		$order_sn = $order['order_sn'];
	
		try {
			$res = $this->sf_apply_order($shop, $order,$account);
		} catch(Exception $e) {
			$result['is_ok'] = false;
			$result['error'] = " failed to ship order {$order['order_sn']} in " . "ht: " . $e->getMessage();
			return $result;
		}
		$shipment = simplexml_load_string($res);
		if(!$shipment) {
			$result['is_ok'] = false;
			$result['error'] = "";
			return $result;
		}else if($shipment->Head == 'ERR'){
			$result['is_ok'] = false;
			$result['error'] = $shipment->ERROR;
			return $result;
		}
		$info = $shipment->Body->OrderResponse->attributes();
		$tracking_number = $info->mailno;
		 
		$result['tracking_number'] = $tracking_number;
		return $result;
	}
	private function sf_apply_order($shop, $order,$account){
		$client = new SoapClient($account['URL'], array( 'keep_alive'=> 'Connection: Keep-Alive'));
		$express_type= 1;
		$xml = '<Request service="OrderService" lang="zh-CN">
			<Head>'.$account['USER'].','.$account['PASSWORD'].'</Head>
			<Body>
				<Order orderid ="'.$order['order_sn'].'"
					   j_company="'.$shop['SHOP_NAME'].'"
		               j_contact="'.$shop['SHOP_NAME'].'"
		               j_tel="'.$shop['SHOP_TEL'].'"
		               j_mobile="'.$shop['SHOP_MOBILE'].'"
		               j_province="'.$shop['SHOP_PROVINCE'].'"
		               j_city="'.$shop['SHOP_CITY'].'"
		               j_county="'.$shop['SHOP_DISTRICT'].'"
		               j_address="'.$shop['SHOP_ADDRESS'].'"
		               d_company="顺丰速运"
		               d_contact="'.htmlspecialchars($order['receive_name']).'"
		               d_tel="'.$order['tel'].'"
		               d_mobile="'.$order['mobile'].'"
		               d_province="'.$order['province_name'].'"
		               d_city="'.$order['city_name'].'"
		               d_county="'.$order['district_name'].'"
		               d_address="'.htmlspecialchars($order['shipping_address']).'"
		               express_type="'.$express_type.'"
		               pay_method="1"
		               custid="'.$account['ACCOUNT'].'"
		               remark="">
	                <Cargo name="' . $order['product_name'] . '">
	                </Cargo>
				</Order>
			</Body>
			</Request>';
			
		$info = new stdClass ();
		$info->arg0 = $xml;
		$info->arg1 = base64_encode ( md5 ( $xml . $account['PASSWORD'], true ) );
		$param = array ( $info );
		$response = $client->__call ( "sfexpressService", $param );
		unset($client);
		/* } catch (Exception $e) { */
		/* 	throw new Exception("sfexpressService SOAP Exception! Message: " . $e->getMessage()); */
		/* } */
		$result =  $response->return;
			
		return $result;
	}

	private function test_zt_account($order,$product,$shop,$account){
		$user = $account['USER'];
		$pw = $account['PASSWORD'];
		$content = array('number' => 1,'lastno' => null);
		$date = date("Y-m-d H:i:s");
// 		$date = '2015-08-11 19:22:22';
// 		print_r($date);
		$data = array(
				'style'=>'json',
				'func'=>'mail.apply',
				'partner'=>$user,
				'datetime'=>$date,//'2015-08-11 11:06:39',
				'verify'=>'',
				'content'=>base64_encode(json_encode($content))
		);
		$data['verify'] = md5($data['partner'].$data['datetime'].$data['content'].$pw);
// 		var_dump($data);die();
		return json_decode($this->post_data('http://partner.zto.cn/partner/interface.php',$data),true);
	}
	
	private function post_data($url,$data){
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$ret = curl_exec ( $ch );
		curl_close ( $ch );
		//	var_dump($ret);
		return $ret;
	}
    
    private function post_json_data($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        return $return_content;
    }
}

class HttpClient {
	// Request vars
	var $host;
	var $port;
	var $path;
	var $method;
	var $postdata = '';
	var $cookies = array();
	var $referer;
	var $accept = 'text/xml,application/xml,application/xhtml+xml,text/html,text/plain,image/png,image/jpeg,image/gif,*/*';
	var $accept_encoding = 'utf-8';
	var $accept_language = 'en-us';
	var $user_agent = 'Incutio HttpClient v0.9';
	// Options
	var $timeout = 20;
	var $use_gzip = true;
	var $persist_cookies = true;  // If true, received cookies are placed in the $this->cookies array ready for the next request
	// Note: This currently ignores the cookie path (and time) completely. Time is not important,
	//       but path could possibly lead to security problems.
	var $persist_referers = true; // For each request, sends path of last request as referer
	var $debug = false;
	var $handle_redirects = true; // Auaomtically redirect if Location or URI header is found
	var $max_redirects = 5;
	var $headers_only = false;    // If true, stops receiving once headers have been read.
	// Basic authorization variables
	var $username;
	var $password;
	// Response vars
	var $status;
	var $headers = array();
	var $content = '';
	var $errormsg;
	// Tracker variables
	var $redirect_count = 0;
	var $cookie_host = '';
	function HttpClient($host, $port=80) {
		$this->host = $host;
		$this->port = $port;
	}
	function get($path, $data = false) {
		$this->path = $path;
		$this->method = 'GET';
		if ($data) {
			$this->path .= '?'.$this->buildQueryString($data);
		}
		return $this->doRequest();
	}
	function post($path, $data) {
		$this->path = $path;
		$this->method = 'POST';
		$this->postdata = $this->buildQueryString($data);
		return $this->doRequest();
	}
	function buildQueryString($data) {
		$querystring = '';
		if (is_array($data)) {
			// Change data in to postable data
			foreach ($data as $key => $val) {
				if (is_array($val)) {
					foreach ($val as $val2) {
						$querystring .= urlencode($key).'='.urlencode($val2).'&';
					}
				} else {
					$querystring .= urlencode($key).'='.urlencode($val).'&';
				}
			}
			$querystring = substr($querystring, 0, -1); // Eliminate unnecessary &
		} else {
			$querystring = $data;
		}
		return $querystring;
	}
	function doRequest() {
		// Performs the actual HTTP request, returning true or false depending on outcome
		if (!$fp = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout)) {
			// Set error message
			switch($errno) {
				case -3:
					$this->errormsg = 'Socket creation failed (-3)';
				case -4:
					$this->errormsg = 'DNS lookup failure (-4)';
				case -5:
					$this->errormsg = 'Connection refused or timed out (-5)';
				default:
					$this->errormsg = 'Connection failed ('.$errno.')';
					$this->errormsg .= ' '.$errstr;
					$this->debug($this->errormsg);
			}
			return false;
		}
		socket_set_timeout($fp, $this->timeout);
		$request = $this->buildRequest();
		$this->debug('Request', $request);
		fwrite($fp, $request);
		// Reset all the variables that should not persist between requests
		$this->headers = array();
		$this->content = '';
		$this->errormsg = '';
		// Set a couple of flags
		$inHeaders = true;
		$atStart = true;
		// Now start reading back the response
		while (!feof($fp)) {
			$line = fgets($fp, 4096);
			if ($atStart) {
				// Deal with first line of returned data
				$atStart = false;
				if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
					$this->errormsg = "Status code line invalid: ".htmlentities($line);
					$this->debug($this->errormsg);
					return false;
				}
				$http_version = $m[1]; // not used
				$this->status = $m[2];
				$status_string = $m[3]; // not used
				$this->debug(trim($line));
				continue;
			}
			if ($inHeaders) {
				if (trim($line) == '') {
					$inHeaders = false;
					$this->debug('Received Headers', $this->headers);
					if ($this->headers_only) {
						break; // Skip the rest of the input
					}
					continue;
				}
				if (!preg_match('/([^:]+):\\s*(.*)/', $line, $m)) {
					// Skip to the next header
					continue;
				}
				$key = strtolower(trim($m[1]));
				$val = trim($m[2]);
				// Deal with the possibility of multiple headers of same name
				if (isset($this->headers[$key])) {
					if (is_array($this->headers[$key])) {
						$this->headers[$key][] = $val;
					} else {
						$this->headers[$key] = array($this->headers[$key], $val);
					}
				} else {
					$this->headers[$key] = $val;
				}
				continue;
			}
			// We're not in the headers, so append the line to the contents
			$this->content .= $line;
		}
		fclose($fp);
		// If data is compressed, uncompress it
		if (isset($this->headers['content-encoding']) && $this->headers['content-encoding'] == 'gzip') {
			$this->debug('Content is gzip encoded, unzipping it');
			$this->content = substr($this->content, 10); // See http://www.php.net/manual/en/function.gzencode.php
			$this->content = gzinflate($this->content);
		}
		// If $persist_cookies, deal with any cookies
		if ($this->persist_cookies && isset($this->headers['set-cookie']) && $this->host == $this->cookie_host) {
			$cookies = $this->headers['set-cookie'];
			if (!is_array($cookies)) {
				$cookies = array($cookies);
			}
			foreach ($cookies as $cookie) {
				if (preg_match('/([^=]+)=([^;]+);/', $cookie, $m)) {
					$this->cookies[$m[1]] = $m[2];
				}
			}
			// Record domain of cookies for security reasons
			$this->cookie_host = $this->host;
		}
		// If $persist_referers, set the referer ready for the next request
		if ($this->persist_referers) {
			$this->debug('Persisting referer: '.$this->getRequestURL());
			$this->referer = $this->getRequestURL();
		}
		// Finally, if handle_redirects and a redirect is sent, do that
		if ($this->handle_redirects) {
			if (++$this->redirect_count >= $this->max_redirects) {
				$this->errormsg = 'Number of redirects exceeded maximum ('.$this->max_redirects.')';
				$this->debug($this->errormsg);
				$this->redirect_count = 0;
				return false;
			}
			$location = isset($this->headers['location']) ? $this->headers['location'] : '';
			$uri = isset($this->headers['uri']) ? $this->headers['uri'] : '';
			if ($location || $uri) {
				$url = parse_url($location.$uri);
				// This will FAIL if redirect is to a different site
				return $this->get($url['path']);
			}
		}
		return true;
	}
	function buildRequest() {
		$headers = array();
		$headers[] = "{$this->method} {$this->path} HTTP/1.0"; // Using 1.1 leads to all manner of problems, such as "chunked" encoding
		$headers[] = "Host: {$this->host}";
		$headers[] = "User-Agent: {$this->user_agent}";
		$headers[] = "Accept: {$this->accept}";
		if ($this->use_gzip) {
			$headers[] = "Accept-encoding: {$this->accept_encoding}";
		}
		$headers[] = "Accept-language: {$this->accept_language}";
		if ($this->referer) {
			$headers[] = "Referer: {$this->referer}";
		}
		// Cookies
		if ($this->cookies) {
			$cookie = 'Cookie: ';
			foreach ($this->cookies as $key => $value) {
				$cookie .= "$key=$value; ";
			}
			$headers[] = $cookie;
		}
		// Basic authentication
		if ($this->username && $this->password) {
			$headers[] = 'Authorization: BASIC '.base64_encode($this->username.':'.$this->password);
		}
		// If this is a POST, set the content type and length
		if ($this->postdata) {
			$headers[] = 'Content-Type: application/x-www-form-urlencoded';
			$headers[] = 'Content-Length: '.strlen($this->postdata);
		}
		$request = implode("\r\n", $headers)."\r\n\r\n".$this->postdata;
		return $request;
	}
	function getStatus() {
		return $this->status;
	}
	function getContent() {
		return $this->content;
	}
	function getHeaders() {
		return $this->headers;
	}
	function getHeader($header) {
		$header = strtolower($header);
		if (isset($this->headers[$header])) {
			return $this->headers[$header];
		} else {
			return false;
		}
	}
	function getError() {
		return $this->errormsg;
	}
	function getCookies() {
		return $this->cookies;
	}
	function getRequestURL() {
		$url = 'http://'.$this->host;
		if ($this->port != 80) {
			$url .= ':'.$this->port;
		}
		$url .= $this->path;
		return $url;
	}
	// Setter methods
	function setUserAgent($string) {
		$this->user_agent = $string;
	}
	function setAuthorization($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	function setCookies($array) {
		$this->cookies = $array;
	}
	// Option setting methods
	function useGzip($boolean) {
		$this->use_gzip = $boolean;
	}
	function setPersistCookies($boolean) {
		$this->persist_cookies = $boolean;
	}
	function setPersistReferers($boolean) {
		$this->persist_referers = $boolean;
	}
	function setHandleRedirects($boolean) {
		$this->handle_redirects = $boolean;
	}
	function setMaxRedirects($num) {
		$this->max_redirects = $num;
	}
	function setHeadersOnly($boolean) {
		$this->headers_only = $boolean;
	}
	function setDebug($boolean) {
		$this->debug = $boolean;
	}
	// "Quick" static methods
	function quickGet($url) {
		$bits = parse_url($url);
		$host = $bits['host'];
		$port = isset($bits['port']) ? $bits['port'] : 80;
		$path = isset($bits['path']) ? $bits['path'] : '/';
		if (isset($bits['query'])) {
			$path .= '?'.$bits['query'];
		}
		$client = new HttpClient($host, $port);
		if (!$client->get($path)) {
			return false;
		} else {
			return $client->getContent();
		}
	}
	public static function quickPost($url, $data) {
		$bits = parse_url($url);
		$host = $bits['host'];
		$port = isset($bits['port']) ? $bits['port'] : 80;
		$path = isset($bits['path']) ? $bits['path'] : '/';
		$client = new HttpClient($host, $port);
		if (!$client->post($path, $data)) {
			return false;
		} else {
			return $client->getContent();
		}
	}
	function debug($msg, $object = false) {
		        if ($this->debug) {
		            print '<div style="border: 1px solid red; padding: 0.5em; margin: 0.5em;"><strong>HttpClient Debug:</strong> '.$msg;
		            if ($object) {
		                ob_start();
		        	    print_r($object);
		        	    $content = htmlentities(ob_get_contents());
		        	    ob_end_clean();
		        	    print '<pre>'.$content.'</pre>';
		        	}
		        	print '</div>';
		        }
	}
}

class Bytes {
	 
	/**
	 * 转换一个String字符串为byte数组
	 * @param $str 需要转换的字符串
	 * @param $bytes 目标byte数组
	 * @author Zikie
	 */

	public static function getBytes($str) {

		$len = strlen($str);
		$bytes = array();
		for($i=0;$i<$len;$i++) {
			if(ord($str[$i]) >= 128){
				$byte = ord($str[$i]) - 256;
			}else{
				$byte = ord($str[$i]);
			}
			$bytes[] =  $byte ;
		}
		return $bytes;
	}
	 
	/**
	 * 将字节数组转化为String类型的数据
	 * @param $bytes 字节数组
	 * @param $str 目标字符串
	 * @return 一个String类型的数据
	 */

	public static function toStr($bytes) {
		$str = '';
		foreach($bytes as $ch) {
			$str .= chr($ch);
		}

		return $str;
	}
	 
	/**
	 * 转换一个int为byte数组
	 * @param $byt 目标byte数组
	 * @param $val 需要转换的字符串
	 * @author Zikie
	 */
	 
	public static function integerToBytes($val) {
		$byt = array();
		$byt[0] = ($val & 0xff);
		$byt[1] = ($val >> 8 & 0xff);
		$byt[2] = ($val >> 16 & 0xff);
		$byt[3] = ($val >> 24 & 0xff);
		return $byt;
	}
	 
	/**
	 * 从字节数组中指定的位置读取一个Integer类型的数据
	 * @param $bytes 字节数组
	 * @param $position 指定的开始位置
	 * @return 一个Integer类型的数据
	 */

	public static function bytesToInteger($bytes, $position) {
		$val = 0;
		$val = $bytes[$position + 3] & 0xff;
		$val <<= 8;
		$val |= $bytes[$position + 2] & 0xff;
		$val <<= 8;
		$val |= $bytes[$position + 1] & 0xff;
		$val <<= 8;
		$val |= $bytes[$position] & 0xff;
		return $val;
	}

	/**
	 * 转换一个short字符串为byte数组
	 * @param $byt 目标byte数组
	 * @param $val 需要转换的字符串
	 * @author Zikie
	 */
	 
	public static function shortToBytes($val) {
		$byt = array();
		$byt[0] = ($val & 0xff);
		$byt[1] = ($val >> 8 & 0xff);
		return $byt;
	}
	 
	/**
	 * 从字节数组中指定的位置读取一个Short类型的数据。
	 * @param $bytes 字节数组
	 * @param $position 指定的开始位置
	 * @return 一个Short类型的数据
	 */

	public static function bytesToShort($bytes, $position) {
		$val = 0;
		$val = $bytes[$position + 1] & 0xFF;
		$val = $val << 8;
		$val |= $bytes[$position] & 0xFF;
		return $val;
	}
	
}
?>
