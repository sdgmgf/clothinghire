<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Productionbatch extends CI_Model {

    private $CI  ;
    private $helper;
    function __construct(){
    	 parent::__construct();
    	 if(!isset($this->CI)){
            $this->CI = & get_instance();
        }
         if(!isset($this->helper)){
           $this->CI->load->library('Helper'); 
           $this->helper = $this->CI->helper;
        }
     }
     
     public function getPickUpProductList($facility_id){
//     	return array(
//     		'list' => array(
//     			'1' => array(
//     				'product_id'   => 1,
//     				'product_name' => '橘子',
//     				'type'		   => array(
//     					'HISTORY_TO_SHIP'		=> 1,
//						'TODAY_OUTER_CITY'      => 22,
//						'TODAY_IN_CITY'			=> 23,
//						'TODAY_OUTER_CITY_WORK' => 24,
//						'TODAY_IN_CITY_WORK'	=> 25,
//						'TODAY_OUTER_CITY_HOME' => 26,
//						'TODAY_IN_CITY_HOME'	=> 27,
//						'TOMORROW_OUTER_CITY'	=> 28,
//						'TOMORROW_IN_CITY'		=> 29,
//						'WEEKEDN_WORK'			=> 30
//     				)
//     			),
//     			'2' => array(
//     				'product_id'   => 2,
//     				'product_name' => '香蕉',
//     				'type'		   => array(
//     					'HISTORY_TO_SHIP'		=> 100,
//						'TODAY_OUTER_CITY'      => 0,
//						'TODAY_IN_CITY'			=> 33,
//						'TODAY_OUTER_CITY_WORK' => 34,
//						'TODAY_IN_CITY_WORK'	=> 35,
//						'TODAY_OUTER_CITY_HOME' => 36,
//						'TODAY_IN_CITY_HOME'	=> 37,
//						'TOMORROW_OUTER_CITY'	=> 38,
//						'TOMORROW_IN_CITY'		=> 39,
//						'WEEKEDN_WORK'			=> 40
//     				)
//     			),
//     			'3' => array(
//     				'product_id'   => 3,
//     				'product_name' => '橘子',
//     				'type'		   => array(
//     					'HISTORY_TO_SHIP'		=> 100,
//						'TODAY_OUTER_CITY'      => 0,
//						'TODAY_IN_CITY'			=> 33,
//						'TODAY_OUTER_CITY_WORK' => 34,
//						'TODAY_IN_CITY_WORK'	=> 35,
//						'TODAY_OUTER_CITY_HOME' => 36,
//						'TODAY_IN_CITY_HOME'	=> 37,
//						'TOMORROW_OUTER_CITY'	=> 38,
//						'TOMORROW_IN_CITY'		=> 39,
//						'WEEKEDN_WORK'			=> 40
//     				)
//     			)
//     		),
//     		'type_list'	=> array(
//     			'HISTORY_TO_SHIP'		=> '昨日应发未发',
//				'TODAY_OUTER_CITY'      => '当日外围件',
//				'TODAY_IN_CITY'			=> '当日同城件',
//				'TODAY_OUTER_CITY_WORK' => '当日外围工作件',
//				'TODAY_IN_CITY_WORK'	=> '当日同城工作件',
//				'TODAY_OUTER_CITY_HOME' => '当日外围家庭件',
//				'TODAY_IN_CITY_HOME'	=> '当日同城家庭件',
//				'TOMORROW_OUTER_CITY'	=> '明日应发外围',
//				'TOMORROW_IN_CITY'		=> '明日应发城市',
//				'WEEKEDN_WORK'			=> '周末公司件'
//     		),
//     		'result' 	=> 'ok',
//     	);
     	return $this->helper->get("/production/uncreated/list/{$facility_id}");
     }
     public function getPickUpProductDetail($facility_id,$product_id,$production_batch_type){
//     	return array(
//     		'list' => array(
//     			'provinces' => array(
//     				'1' => array(
//     					'province_id'   => 1,
//	     				'province_name' => '浙江',
//	     				'length'		=> 2,
//	     				'citys'		    => array(
//	     					'11'		=> array(
//	     						'city_id' => '11',
//	     						'city_name' => '杭州市',
//	     						'districts' => array(
//	     							'111' => array(
//	     								'district_id' 	=> 111,
//	     								'district_name' => '西湖区',
//	     								'num'			=> '10',
//	     							),
//	     							'112' => array(
//	     								'district_id' 	=> 112,
//	     								'district_name' => '滨江区',
//	     								'num'			=> '10',
//	     							),
//	     							'113' => array(
//	     								'district_id' 	=> 113,
//	     								'district_name' => '上城区',
//	     								'num'			=> '10',
//	     							),
//	     						)
//	     					),
//	     					'12'		=> array(
//	     						'city_id' 	=> '12',
//	     						'city_name' => '温州市',
//	     						'districts' => array(
//	     							'1' => array(
//	     								'district_id' 	=> 121,
//	     								'district_name' => '鹿城区',
//	     								'num'			=> '10',
//	     							),
//	     							'2' => array(
//	     								'district_id' 	=> 122,
//	     								'district_name' => '瓯海区',
//	     								'num'			=> '10',
//	     							),
//	     							'3' => array(
//	     								'district_id' 	=> 123,
//	     								'district_name' => '瑞安市',
//	     								'num'			=> '10',
//	     							),
//	     						)
//	     					),
//	     				)
//     				),
//     				'2' => array(
//     					'province_id'   => 2,
//	     				'province_name' => '上海',
//	     				'length'		=> 1,
//	     				'citys'		    => array(
//	     					'21'		=> array(
//	     						'city_id' => '21',
//	     						'city_name' => '上海市',
//	     						'districts' => array(
//	     							'211' => array(
//	     								'district_id' 	=> 211,
//	     								'district_name' => '长宁区',
//	     								'num'			=> '10',
//	     							),
//	     							'212' => array(
//	     								'district_id' 	=> 212,
//	     								'district_name' => '浦东区',
//	     								'num'			=> '10',
//	     							),
//	     							'213' => array(
//	     								'district_id' 	=> 213,
//	     								'district_name' => '青浦区',
//	     								'num'			=> '10',
//	     							),
//	     						)
//	     					)
//	     				)
//     				),
//     			)
//     		),
//     		'result' 	=> 'ok',
//     	);
     	return $this->helper->get("/production/uncreated/detail/{$facility_id}/{$product_id}/{$production_batch_type}");
     }
     				
     
     
     public function createProductionBatch($params){
//     	$params = array(
//     		'facility_id'	=>  '1',
//     		'list'			=>  array(
//     			'179'	=> array(
//     				'product_id'			=>'179',
//     				'production_batch_type'	=>'HISTORY_TO_SHIP',
//     				'district_ids'			=> array('2703','2704','3230'),
//     				'is_all'				=> '0'
//     			),
//     		),
//     	);
     	$out = $this->helper->post("/production/batch/created",$params);
     	return $out;
     }
     
     public function getProductionBatchList($cond,$offset,$limit) {
     	if(empty($cond)){
     		$cond = array();
     	}
     	$cond['offset'] = $offset;
     	$cond['size'] = $limit;
     	$out =  $this->helper->get("/production/batch/list",$cond);
     	$result = array();
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getProductionBatch($production_batch_sn,$cond) {
     	$out =  $this->helper->get("/production/batch/".$production_batch_sn,$cond);
     	$result = array();
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     public function getProductionBatchSummary($production_batch_id){
     	return $this->helper->get("/production/batch/summary/".$production_batch_id);
     }
     public function getProductionItemList($production_batch_id){
     	return $this->helper->get("/production/batch/item_list/".$production_batch_id);
     }
     public function getProductionBatchItemDetail($production_batch_id){
     	return $this->helper->get("/production/batch/item_list_detail/".$production_batch_id);
     }
     
     public function packagePickUp($production_batch_item_id, $params){
     	$out = $this->helper->post('/production/batch/item/package/'.$production_batch_item_id,$params);
     	return $out;
     }
     
     public function materialPickUp($production_batch_item_id, $params) {
     	return $this->helper->post('/production/batch/item/material/'.$production_batch_item_id,$params);
     }
     
     public function getProductionBatchProgress($production_batch_id) {
     	return $this->helper->get('/production/batch/progress/detail/'.$production_batch_id);
     }
     
     public function getShipmentDetailList($params) {
     	return $this->helper->get('/production/shipment/detail/list', $params);
     }
}