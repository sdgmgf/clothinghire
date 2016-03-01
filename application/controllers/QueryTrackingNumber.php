<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
 */
class QueryTrackingNumber extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'session' );
		$this->load->library ( 'Pager' );
		$this->load->library ( 'Helper' );
		$this->load->model ( 'tracking' );
		$this->helper->chechActionList(array('queryTrackingNumber'),true);
	}
	public function index() {
		$this->load->view ( 'query_tracking_number', array() );
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name) {
		$out = trim ( $this->input->post ( $name ) );
		if (isset ( $out ) && $out != "") {
			return $out;
		} else {
			$out = trim ( $this->input->get ( $name ) );
			if (isset ( $out ) && $out != "")
				return $out;
		}
		return null;
	}
	
	public function queryTrackingNumber() {
		$cond = array ();
		$mobile = $this->getInput('mobile');
		$receive_name = $this->getInput('receive_name');
		if ($mobile) {
			$cond['mobile'] = $mobile;
		}
		if ($receive_name) {
			$cond['receive_name'] = $receive_name;
		}
		
		if (! isset($cond['mobile']) && ! isset($cond['receive_name'])) {
			die("参数错误");
		}
		$out = $this->tracking->getTrackingNumber ($cond);
		if (isset($out['error_info'])) {
			die("查询失败,{$out['error_info']}");
		}
		$cond['order_list'] = $out['data']['order_list'];
		$data = $this->helper->merge ($cond);
		$this->load->view ( 'query_tracking_number', $data );
	}
}
?>