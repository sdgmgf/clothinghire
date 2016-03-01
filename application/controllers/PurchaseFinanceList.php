<?php

class PurchaseFinanceList extends CI_Controller {
	function __construct(){
		parent::__construct();
      	$this->load->library('Pager'); 
		$this->load->library('session');
		$this->load->model('common');
		$this->load->library('Helper');
		$this->load->library('Excel');
		$this->load->model('purchasefinance');
		$this->load->model('productmodel');
		$this->helper->chechActionList(array('purchaseFinanceApply', 'purchaseFinance'),true);
	}
	
	public function getProductTypeList(){
		$product_type_list =  array();
		if($this->helper->chechActionList(array('caigouManager','purchaseFinance'))) {
			$item['product_type'] = 'goods';
			$item['product_type_name'] = '商品';
			$product_type_list[] = $item;
		}
		if($this->helper->chechActionList(array('suppliesCaigouManager','purchaseFinance'))) {
			$item['product_type'] = 'supplies';
			$item['product_type_name'] = '耗材';
			$product_type_list[] = $item;
		}
		 
		return $product_type_list;
	}
	
	public function index() {
		$product_type_list = $this->getProductTypeList();
    	if(empty($product_type_list)) {
    		die("无权限");
    	}
    	$cond['product_type_list'] = $product_type_list;
		$out = $this->common->getFacilityList();
		$cond['facility_list'] = $out['data'];
		$cond['start_time'] = date('Y-m-d 00:00:00', time());
		$data = $this->helper->merge($cond);
		$this->load->view("purchase_finance_list",$data);
	}
	
	public function query() {
		$cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端
		if(isset($cond['act']) && $cond['act'] == 'download'){    // 下载
			$this->purchaseFinanceDownload($cond);
			return ;
		}
		$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
		$limit = $cond['page_limit'];
		$cond['offset'] = $offset;
		$cond['size'] = $limit;
		$out = $this->purchasefinance->getPurchaseFinanceList($cond);
		$product_type_list = $this->getProductTypeList();
    	if(empty($product_type_list)) {
    		die("无权限");
    	}
    	$cond['product_type_list'] = $product_type_list;
		$cond['purchase_finance_price_list'] = $out['data']['data']['purchase_finance_price_list'];
		//分页
		$record_total = $out['data']['data']['total'];
		$page_count = $cond['page_current']+3;
		if(count($cond['purchase_finance_price_list']) < $limit ){
			$page_count = $cond['page_current'];
		}
		if(!empty($record_total)){
			$cond['record_total'] = $record_total;
			$page_count = ceil($record_total / $limit );
		}
		$cond['page_count'] = $page_count;
		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
		
		$out = $this->common->getFacilityList();
		$cond['facility_list'] = $out['data'];
		$data = $this->helper->merge($cond);
		$this->load->view('purchase_finance_list',$data);
	}
	
	private function purchaseFinanceDownload($cond){
		$cond['offset'] = 0;
		$cond['size'] = 10000;
		$out = $this->purchasefinance->getPurchaseFinanceList($cond);
		$head = array('ASN日期','区域','仓库','商品名称','商品编码','采购员','供应商','采购总数',
				'采购箱数','采购箱规','入库总数','入库总箱数','入库信息','入库单价',
				'总金额','单位');
		$body = array();
		if(isset($out['data']['data'])){
			$purchase_finance_price_list = $out['data']['data']['purchase_finance_price_list'];
			$index = 0;
			foreach ($purchase_finance_price_list as $key => $entry) {
				$body[$index][] = $entry['asn_date'];
				$body[$index][] = $entry['area_name'];
				$body[$index][] = $entry['facility_name'];
				$body[$index][] = $entry['product_name'];
				$body[$index][] = $entry['product_id'];
				$body[$index][] = $entry['purchase_user'];
				$body[$index][] = $entry['product_supplier_name'];
				$body[$index][] = $entry['purchase_total_num'];
				$body[$index][] = $entry['purchase_case_num'];
				$body[$index][] = $entry['purchase_container_quantity'];
				$body[$index][] = $entry['arrival_real_quantity'];
				$body[$index][] = $entry['arrival_case_num'];
				if(count($entry['inventory_list']) > 0) {
					$arrival_info = '';
					foreach ($entry['inventory_list'] as $inventory) {
						$arrival_info .= '入库箱数：'.$inventory['quantity'].',入库箱规：'.$inventory['unit_quantity'].',入库员：'.$inventory['created_user'].';';
					}
					$body[$index][] = $arrival_info;
				} else {
					$body[$index][] = '';
				}
				$body[$index][] = $entry['arrival_unit_price'];
				$body[$index][] = $entry['purchase_total_price'];
				$body[$index][] = $entry['product_unit_code'];
				$index++;
			}
		}
		$this->download($head,$body,"采购价格列表");
	}
	
	// 导出 excel
	private function download($head,$body,$fileName){
		$excel =  $this->excel;
		$excel->addHeader($head);
		$excel->addBody($body);
		$excel->downLoad($fileName);
	}
	
	// 获取前端 post 传递过来的查询条件
	private function getQueryCondition( ){
		$cond = array();
		
		$act = $this->getInput('act');    // 查询 还是 下载
		if(isset($act)) {
			$cond['act'] = $act;
		}
		
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id) && $facility_id != 'all'){
			$cond['facility_id'] = $facility_id;
		}
	    
	    $product_name = $this->getInput('product_name');
	    if (  isset($product_name)) {
	    	$cond['product_name'] = $product_name;
	    }
	    
	    $product_type = $this->getInput('product_type');
	    if (  isset($product_type)) {
	    	$cond['product_type'] = $product_type;
	    }
	     
		$start_time = $this->getInput('start_time');
		if(isset($start_time)){
			$cond['start_time'] = $start_time;
		}
		
		$end_time = $this->getInput('end_time');
		if(isset($end_time)){
			$cond['end_time'] = $end_time;
		}
		$asn_date_start = $this->getInput('asn_date_start');
		if(isset($asn_date_start)){
			$cond['asn_date_start'] = $asn_date_start;
		}
		
		$asn_date_end = $this->getInput('asn_date_end');
		if(isset($asn_date_end)){
			$cond['asn_date_end'] = $asn_date_end;
		}
		$asn_date = $this->getInput('asn_date');
		if(isset($asn_date)){
			$cond['asn_date'] = $asn_date;
		}
		
		$status = $this->getInput('status');
		if(isset($status)){
			$cond['status'] = $status;
		}
		
		$apply_user = $this->getInput('apply_user');
		if(isset($apply_user)){
			$cond['apply_user'] = $apply_user;
		}
		$asn_item_id = $this->getInput('asn_item_id');
		if(isset($asn_item_id)){
			$cond['asn_item_id'] = $asn_item_id;
		}
		
		$page_current = $this->getInput('page_current');
		if(!empty($page_current)) {
			$cond['page_current'] = $page_current;
		}else{
			$cond['page_current'] = 1;
		}
		$page_limit = $this->getInput('page_limit');
		if(!empty($page_limit)) {
			$cond['page_limit'] = $page_limit;
		}else{
			$cond['page_limit'] = 10;
		}
		
		return $cond;
	}
	
	public function freezed() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->freezed($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
	public function checked() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->checked($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
	public function checkfail() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->checkfail($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}

	public function paid() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->paid($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	public function recover(){
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->recover($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
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
	
	public function apply() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->apply($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	//区总
	public function purchaseManagerChecked() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->purchaseManagerChecked($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
	public function purchaseManagerCheckfail() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->purchaseManagerCheckfail($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	//主管审批
	public function purchaseDirectorChecked() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->purchaseDirectorChecked($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
	public function purchaseDirectorCheckfail() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->purchaseDirectorCheckfail($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
}

?>
