<?php

class StationKeyword extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Helper');
		$this->load->library('Pager');
		$this->load->library('upload');
		$this->load->helper(array('form','url'));
		$this->load->model('station');
		$this->helper->chechActionList(array('stationManage','stationStatistics','stationList'),true);
	}
    public function index() {
    	
	}
	public function availableShipments(){
		$data = $this->helper->merge(array());
		$this->load->view('available_keyword_shipments',$data);
	}
    public function getAvailableShipments() {
        $city_id = $this->getInput('city_id');
        $keyword = $this->getInput('keyword');
        $input = array(
        	'city_id' => $city_id,
        	'keyword' => $keyword
        );
        $out = $this->station->getAvailableShipments($input);
        echo json_encode($out);
    }
    /*
     * 
     */
    public function getMainAvailableCitys(){
        $out = $this->station->getAvailableCitys();
        echo json_encode($out);
    }
	public function getCoverageRegion(){

		$parent_id = $this->getInput('parent_id');
		$region_type = $this->getInput('region_type');
        $shipping_id = $this->getInput('shipping_id');
		$data = array(

			'parent_id' => $parent_id,
			'region_type' => $region_type,
            'shipping_id' => $shipping_id,
		);
		if(empty($data)){

			echo json_encode( array( "result" => 'fail','error_info'=>'请输入parent_id以及region_type以及shipping_id' ) );
		}else{

			$out = $this->station->getStationSubRegions($data);
			echo json_encode($out);
		}
	}
	public function getAvailableShipping(){
		$is_self = $this->getInput('is_self');
		$data = array(
			'is_self' => $is_self
		);
		if(empty($data)){
			echo json_encode( array( "result" => 'fail','error_info'=>'请输入is_self' ) );
		}else{
			$out = $this->station->getAvailableShipping($data);
			echo json_encode($out);
		}
	}
    public function getAvailableDistricts(){
    	$station_id = $this->getInput('station_id');
		$cond = array();
		if(!empty($station_id)){
			$cond['station_id'] = $station_id;
		}
    	if(empty($cond)){
    		echo json_encode( array( "result" => 'fail','error_info'=>'请输入station_id' ) );
    	}else{
    		$out = $this->station->getAvailableDistricts($cond);
        	echo json_encode($out);
    	}
    }
    
    public function stationList(){
    	$data = $this->helper->merge(array());
    	$this->load->view('station_list',$data);
    }
    public function stationInfo(){
    	$data = $this->helper->merge(array());
    	$this->load->view('station_info',$data);
    }
    public function getStationList(){
    	$data = array();
    	$city_id = $this->getInput('city_id');
    	if(!empty($city_id)){
    		$data['city_id'] = $city_id;
    	}
    	$out = $this->station->getStationList($data);
        echo json_encode($out);
    }
    public function getStationInfo(){
    	$station_id = $this->getInput('station_id');
    	if(empty($station_id)){
    		echo json_encode( array( "result" => 'fail','error_info'=>'请输入station_id' ) );
    	}else{
    		$out = $this->station->getStationInfo($station_id);
        	echo json_encode($out);
    	}
    }
    public function getStationKeyword(){
    	$station_id = $this->getInput('station_id');
    	if(empty($station_id)){
    		echo json_encode( array( "result" => 'fail','error_info'=>'请输入station_id' ) );
    	}else{
    		$out = $this->station->getStationKeyword($station_id);
        	echo json_encode($out);
    	}
    }
    /*
    $station_id = 3;
    $station_keywords = array(
    	0 => array(
    		'district_id' => '3279',
    		'keyword'	  => '华楼巷31号，宁波宏硕国际货运代理有限公司'
    	),
    	1 => array(
    		'district_id' => '3279',
    		'keyword'	  => '和义路96号宁波市电信局'
    	),
    );
    */
    public function addStationKeyword(){
    	$station_id = $this->getInput('station_id');
    	$station_keywords = $this->input->post('station_keywords');
    	if(empty($station_id)){
    		echo json_encode( array( "result" => 'fail','error_info'=>'请输入station_id' ) );
    	}else{
    		$out = $this->station->addStationKeyword($station_id,array('station_keywords'=>$station_keywords));
        	echo json_encode($out);
    	}
    }
    /*
     * 删除站点关键词
     * $station_id = 3;
     * $station_keyword_ids = array('35503','35508');
     * */
    public function deleteStationKeyword(){
    	$station_id = $this->getInput('station_id');
    	$station_keyword_ids = $this->input->post('station_keyword_ids');
    	if(empty($station_id)){
    		echo json_encode( array( "result" => 'fail','error_info'=>'请输入station_id' ) );
    	}else{
    		$out = $this->station->deleteStationKeyword($station_id,array('station_keyword_ids'=>$station_keyword_ids));
        	echo json_encode($out);
    	}
    }
	//新增站点
	public function addStation(){
		$cond = array();
		$cond['shipping_id'] = $this->getInput('shipping_id');
		$cond['station_name'] = $this->getInput('station_name');
		$cond['station_code'] = $this->getInput('station_code');
		$cond['city_id'] = $this->getInput('city_id');
		$cond['district_id'] = $this->getInput('district_id');
		$cond['shipping_address'] = $this->getInput('shipping_address');
		$cond['courier_name'] = $this->getInput('courier_name');
		$cond['courier_phone'] = $this->getInput('courier_phone');
        $cond['mid'] = $this->getInput('mid');
		$out = $this->station->addStation($cond);
		echo json_encode($out);
	}
    //关闭站点
	public function closeStation(){
		$station_id = $this->getInput('station_id');
		if(empty($station_id)){
			echo json_encode( array( "result" => 'fail','error_info'=>'请输入station_id' ) );
		} else{
			$out = $this->station->closeStation($station_id);
			echo json_encode($out);
		}
	}
    //启用站点
    public function enableStation(){
        $station_id = $this->getInput('station_id');
        if(empty($station_id)){
            echo json_encode( array( "result" => 'fail','error_info'=>'缺少station_id' ) );
        } else{
            $out = $this->station->enableStation($station_id);
            echo json_encode($out);
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
}

?>
