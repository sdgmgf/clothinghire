<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PrintAction extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  $this->load->library('session'); 
    $this->load->library('Pager'); 
    $this->load->library('Helper'); 
    $this->load->model('order');
    $this->load->model('shipment');
	}

	public function first() {
		$cond['batch_pick_sn'] = $this->getInput('batch_pick_sn');
		 
		$data = $this->helper->merge($cond);
		$this->load->view('first-arata',$data);
	}
  public function index()
  {
  	
	error_reporting(E_ALL ^ E_NOTICE);
	$sinri_plus = array();
	
	$order = array(
		"order_amount" => $this->getInput('order_amount'),
		"product_amount" => $this->getInput('product_amount'),
		"order_sn" => $this->getInput('order_sn'),
		"province" => $this->getInput('province'),
		"city" => $this->getInput('city'),
		"district" => $this->getInput('district'),
		"mobile" => $this->getInput('mobile'),
		"tel" => $this->getInput('tel'),
		"consignee" => $this->getInput('consignee'),
		"address" => $this->getInput('address'),
		"tracking_number" => $this->getInput('tracking_number'),
		"print_index" => $this->getInput('print_index'),
		"station" => $this->getInput('station'),
		"station_no" => $this->getInput('station_no'),
		"title" => $this->getInput('title'),
		"facility_address" => $this->getInput('facility_address'),
		"facility_id" => $this->getInput('facility_id'),
		"is_self_template" => $this->getInput('is_self_template'),
		"send_addr_code" => $this->getInput('send_addr_code'),
		"sf_account" => $this->getInput('sf_account'),
		"page_index" => $this->getInput('page_index'),
		"sender_branch_no" => $this->getInput('sender_branch_no'),
		"sender_branch" => $this->getInput('sender_branch'),
		"package_no" => $this->getInput('package_no'),
		"package" => $this->getInput('package'),
		"lattice_mouth_no" => $this->getInput('lattice_mouth_no'),
		"shipping_name" => $this->getInput('shipping_name'),
	);
	$order['tpl'] = 'general-arata';
	if(($order['is_self_template'] == 1))
	{
		if ($this->getInput('shipping_id') == 44 || $this->getInput('shipping_id') == 45) {
			$order['tpl'] = 'sf-general-arata';
		} elseif ($this->getInput('shipping_id') == 88) {
			$order['tpl'] = 'benben-general-arata';
		} elseif ($this->getInput('shipping_id') == 84 || $this->getInput('shipping_id') == 85) {
			$order['tpl'] = 'yto-general-arata';
		} elseif ($this->getInput('shipping_id') == 1) {
			$order['tpl'] = 'sto-general-arata';
		} elseif ($this->getInput('shipping_id') == 3) {
			$order['tpl'] = 'best-general-arata'; 
		} elseif ($this->getInput('shipping_id') == 4) {
			$order['tpl'] = 'yd-general-arata';
		} elseif ($this->getInput('shipping_id') == 91) {
			$order['tpl'] = 'cs100-general-arata';
		} elseif ($this->getInput('shipping_id') == 115) {
			$order['tpl'] = 'zto-general-arata';
        } elseif( $this->getInput('shipping_id') == 5){
            $order['tpl'] = 'ttkd-general-arata';
        }
	} else {
		if ($this->getInput('shipping_id') == 44) {
			$order['tpl'] = 'sf-arata';
		} elseif ($this->getInput('shipping_id') == 45) {
			$order['tpl'] = 'sfhy-arata';
		} elseif ($this->getInput('shipping_id') == 88) {
			$order['tpl'] = 'benben-arata';
		} elseif ($this->getInput('shipping_id') == 84 || $this->getInput('shipping_id') == 85) {
			$order['tpl'] = 'yto-arata';
		} elseif ($this->getInput('shipping_id') == 1) {
			$order['tpl'] = 'sto-arata';
		} elseif ($this->getInput('shipping_id') == 3) {
			$order['tpl'] = 'best-general-arata';
		} elseif ($this->getInput('shipping_id') == 89) {
			$order['tpl'] = 'saiaotong-general-arata';
		} elseif ($this->getInput('shipping_id') == 90) {
			$order['tpl'] = 'sb-general-arata';
		} elseif ($this->getInput('shipping_id') == 4) {
			$order['tpl'] = 'yd-general-arata';
		} elseif ($this->getInput('shipping_id') == 91) {
			$order['tpl'] = 'cs100-general-arata';
		} elseif ($this->getInput('shipping_id') == 92) {
			$order['tpl'] = 'fc-general-arata';
		} elseif ($this->getInput('shipping_id') == 115) {
			$order['tpl'] = 'zto-arata';
		} elseif( $this->getInput('shipping_id') == 5){
            $order['tpl'] = 'ttkd-general-arata';
        }
	}
	$result = $this->shipment->printShipment($this->getInput('shipment_id'));
	
	if (isset($result['error_info'])) {
		$this->helper->log("PrintAction shipment_id " .$this->getInput('shipment_id') . " tracking_number " .$this->getInput('tracking_number') . " error_info " . $result['error_info']);
	}
	
	
	$order['c_tel'] = "400-067-1217";
	$order['party_name'] = $order['title'];
	// 备注 
	$order['remarks'] = '';
	$order['need_insure'] = false;
	$order['is_sf_cod'] = false;
	$order['sf_cod_note'] = false;
	
	$order['p_time'] = date("Y    m    d ");
	$order['product_type']="生鲜";
	$code = $this->getInput('secrect_code');
	if(!empty($code)){
		$order['product_type'] .="(" . $code. ")";
	}
	
	//金额大写转换
	$money = "";
	$money = $this->Change($order['order_amount']);
	
	$arata=array(
		'ztoSender'=> $order['title'],
		'sentBranch'=> $order['title'],
		'tracking_number'=>$order['tracking_number'],
		'service_type'=>$order['product_type'],
	);
	$order['company_address'] =  $order['facility_address'];
	$cond['money'] = $money;
	$cond['sinri_plus'] = $sinri_plus;
	$cond['arata'] = $arata;
	$cond['order'] = $order;
	
	if ($this->getInput('shipping_id') == 44 || $this->getInput('shipping_id') == 3 || $this->getInput('shipping_id') == 4 || $this->getInput('shipping_id') == 91) {
		$cond['codeImg'] = $this->helper->getUrl() . "index.php?sb_ci=&code128=&text={$arata['tracking_number']}";
		$cond['codeImg2'] = $this->helper->getUrl() . "index.php?sb_ci=&code128=&text={$arata['tracking_number']}";
	} else {
		$cond['codeImg'] = $this->helper->getUrl() . "codeImg?barcode={$arata['tracking_number']}" . "&height=80&width=500&text=0";
		$cond['codeImg2'] = $this->helper->getUrl() . "codeImg?barcode={$arata['tracking_number']}" . "&height=40&width=300&text=0";
	}
	
	if($this->getInput('shipping_id') == 4) {
		$cond['packageImg'] = $this->helper->getUrl() . "index.php?sb_ci=&code128=&text={$order['package_no']}";
		$cond['codeImg3'] = $this->helper->getUrl() . "index.php?rotation=270&sb_ci=&code128=&text={$arata['tracking_number']}";
	}
	
	$data = $this->helper->merge($cond); 
	$this->load->view($order['tpl'],$data);
  }
  
 function Change($order_amount = 0){
    //$str = "零壹贰叁肆伍陆柒捌玖";
    $str = array(   "0" => '零',
                    "1" => '壹',
                    "2" => '贰',
                    "3" => '叁',
                    "4" => '肆',
                    "5" => '伍',
                    "6" => '陆',
                    "7" => '柒',
                    "8" => '捌',
                    "9" => '玖',
                  );
    
    $order_amount = str_pad(strval(round($order_amount)), 5, '0', STR_PAD_LEFT); 
    $order_amount_arr = str_split($order_amount);

	foreach ($order_amount_arr as $singleChar) {
		$money .= $str[$singleChar];
	}

	return $money;

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
}
?>
