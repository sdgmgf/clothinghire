<?php

class SkuShipping extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('region');
		$this->load->model('facility');
		$this->load->model('coverage');
		$this->load->model('distributeshipping');
		$this->load->model('productmodel');
	}
	public function facilityList(){
		$input = array();
		$out = $this->facility->getFacilityCoverage($input);
		$data = $this->helper->merge($out);
		$this->load->view('facility_coverage',$data);
	}
	public function distributeShippingRule(){
		$cond = array();
		$data = $this->helper->merge($cond);
		$this->load->view('distribute_shipping_rule',$data);
	}
	public function distributeShippingRuleDetail(){
		$cond = array();
		$data = $this->helper->merge($cond);
		$this->load->view('distribute_shipping_rule_detail',$data);
	}
	public function getSkuShippingList(){
		$area_id = $this->getInput('area_id');
		$facility_id = $this->getInput('facility_id');
		$product_id = $this->getInput('product_id');
		
		$input = array(
			'area_id' 	  => $area_id,
			'facility_id' => $facility_id,
			'product_id'  => $product_id
		);
		$out = $this->distributeshipping->getDistributionShippingList($input);
		echo json_encode($out);
	}
	public function getPackagingList(){
		$product_id = $this->getInput('product_id');
		$input = array(
			'product_id' => $product_id
		);
		$out = $this->distributeshipping->getPackagingList($input);
		echo json_encode($out);
	}
	public function getDistributionShippingDetail(){
		$facility_id = $this->getInput('facility_id');
		$product_id = $this->getInput('product_id');
		$shipping_id = $this->getInput('shipping_id');
		$out = $this->distributeshipping->getDistributionShippingDetail($facility_id,$product_id,$shipping_id);
		echo json_encode($out);
	}
	public function addDistributionShippingRule(){
    	$facility_id = $this->getInput('facility_id');
		$product_id = $this->getInput('product_id');
		$shipping_id = $this->getInput('shipping_id');
		$data = array();
		$temp = $this->input->post("district_ids");
		if(is_array($temp) && count($temp)>0){
			$data['district_ids'] = implode(',',$temp);
		}

		
		$out = $this->distributeshipping->addDistributionShippingRule($facility_id,$product_id,$shipping_id,$data);
		echo json_encode($out);
    }

	public function skuShippingList(){
		$facility_id = $this->getInput('facility_id');
		$data['facility'] = $this->facility->getFacilityByFacilityId($facility_id);//获取仓库信息
		

		$out = $this->facility->getAvaiableProduct($facility_id);
		$data['product_list'] = $out['data']['facility_product_list'];
		if(empty($data['product_list']) || !is_array($data['product_list']))
			unset($data['product_list']);
		if(empty($data['product_list'])){
			die('该仓库商品白名单未设置');
		}
		//根据facility_id查找出所有快递方式
		$out = $this->facility->getShipping($facility_id);
		if(empty($out)){
			die('该仓库未开通快递');
		}
		$data['facility_shipping_list'] = $out['facility_shipping_list'];
		
		$province_list = $this->coverage->getFacilityCoverageProvinces($facility_id);
		$city_list = array();
		if(isset($province_list) && isset($province_list['data']) && isset($province_list['data']['list'][0])){
			$city_list 	   = $this->coverage->getFacilityCoverageCitys($facility_id,$province_list['data']['list'][0]['region_id']);
		}else{
			die('该仓库快递覆盖区域未设置');
		}
		$district_list = array();
		if(isset($city_list) && isset($city_list['data']) && isset($city_list['data']['list'][0])){
			$district_list = $this->coverage->getFacilityCoverageDistricts($facility_id,$city_list['data']['list'][0]['region_id']);	
		}else{
			die('该仓库快递覆盖区域未设置');
		}
		
		$data['province_list'] = isset($province_list['data']['list']) ? $province_list['data']['list'] : array();
		$data['city_list'] = isset($city_list['data']['list']) ? $city_list['data']['list'] : array();
		$data['district_list'] = isset($district_list['data']['list']) ? $district_list['data']['list'] : array();
		
		$data = $this->helper->merge($data);
		$this->load->view('sku_shippings',$data);
	}
	public function getProductPackagingName(){
		$facility_id = $this->getInput('facility_id');
		$goods_product_id = $this->getInput('goods_product_id');
		$shipping_id = $this->getInput('shipping_id');
		$input = array(
			'facility_id'		=>	$facility_id,
			'goods_product_id'	=>	$goods_product_id,
			'shipping_id'		=>	$shipping_id
		);
		$res = $this->productmodel->getProductPackagingName($input);
		echo json_encode($res);
	}
	
	public function shippingList(){
		$facility_id = $this->getInput('facility_id');
		$data['facility'] = $this->facility->getFacilityByFacilityId($facility_id);//获取仓库信息
		$data['sku_shipping'] = $this->facility->getProductShippings($facility_id);//获取仓库中各sku的快递信息
		$data = $this->helper->merge($data);
		$this->load->view('sku_shipping_sect',$data);
	}
	
	public function skuShippingDetail(){
		$facility_id = $this->getInput('facility_id');
		$product_id = $this->getInput('product_id');
		$data = array();
		if(!empty($facility_id) && !empty($product_id)){
			$param = array('facility_id'=>$facility_id, 'product_id'=>$product_id);
			$res = $this->facility->getRegionShippings($param);
			$city_num = array();
			foreach ($res['list'] as $record){
				if(!array_key_exists($record['city'], $city_num)){
					$city_num[$record['city']] = 0;
				}
				$city_num[$record['city']]++;
			}
			$data['region_shipping'] =$res['list'];
			$data['product'] = $res['product'];
			$data['city_num'] = $city_num;
			
			//根据facility_id查找出所有快递方式
			$out = $this->facility->getShipping($facility_id);
			$data['facility_shipping_list'] = $out['facility_shipping_list'];
		}
		$data = $this->helper->merge($data);
		$this->load->view('sku_shipping_detail',$data);
	}
	
	public function modifyRegionShipping(){
		$data = $this->getPostData();
		$this->facility->modifyRegionShipping($data);
	}
	
	public function deleteRegionShipping(){
		$sku_region_shipping_id = $this->getInput('sku_region_shipping_id');
		$this->facility->deleteRegionShipping($sku_region_shipping_id);
	}
	
	public function addSkuShipping(){
		$data = $this->getPostData();
		$this->facility->addSkuShipping($data);
	}
	
	public function skuShippingDistribute(){
		$facility_id = $this->getInput('facility_id');
		$data = array();
		if(!empty($facility_id))
			$data = $this->facility->getProductRegionShipping($facility_id);
// 		$data = $this->helper->merge($data);
		$this->load->view('sku_shipping_distribute',$data);
	}
	
	public function getPostData(){
		$data = array();
		$temp = $this->getInput("facility_id");
		if(!empty($temp)){
			$data['facility_id'] = $temp;
		}
		$temp = $this->getInput("product_id");
		if(!empty($temp)){
			$data['product_id'] = $temp;
		}
		$temp = $this->getInput("region_type");
		if(!empty($temp)){
			$data['region_type'] = $temp;
		}
		$temp = $this->getInput("region_id");
		if(!empty($temp)){
			$data['region_id'] = $temp;
		}
		$temp = $this->getInput("shipping_id");
		if(!empty($temp)){
			$data['shipping_id'] = $temp;
		}
		$temp = $this->getInput("sku_region_shipping_id");
		if(!empty($temp)){
			$data['sku_region_shipping_id'] = $temp;
		}
		return $data;
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