<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
 */
class TrackingPrint extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->library ( 'session' );
		$this->load->library ( 'Pager' );
		$this->load->library ( 'Helper' );
		$this->load->model ( 'tracking' );
		$this->helper->chechActionList(array('trackingPrint'),true);
	}
	public function index() {
		$this->load->view ( 'tracking_print_list', array () );
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
	
	// 获取前端 post 传递过来的查询条件
	private function getQueryCondition() {
		$cond = array ();
		
		$tracking_number = $this->getInput ( 'tracking_number' );
		if (isset ( $tracking_number )) {
			$cond ['tracking_number'] = $tracking_number;
		}
		$shipment_id = $this->getInput ( 'shipment_id' );
		if (isset ( $shipment_id )) {
			$cond ['shipment_id'] = $shipment_id;
		}
		
		$page_current = $this->getInput ( 'page_current' );
		if (! empty ( $page_current )) {
			$cond ['page_current'] = $page_current;
		} else {
			$cond ['page_current'] = 1;
		}
		$page_limit = $this->getInput ( 'page_limit' );
		if (! empty ( $page_limit )) {
			$cond ['page_limit'] = $page_limit;
		} else {
			$cond ['page_limit'] = 10;
		}
		
		return $cond;
	}
	
	// 查询得到订单列表
	public function query() {
		$cond = $this->getQueryCondition (); // 获取查询条件 下面需要把条件传递到前端
		$offset = (intval ( $cond ['page_current'] ) - 1) * intval ( $cond ['page_limit'] );
		$limit = $cond ['page_limit'];
		// 获取订单列表
		$out = $this->tracking->getTracking ( $cond, $offset, $limit );
		if (! isset ( $out ['data'] )) { // 调用 api 出现错误
			$con ['error_info'] = $out ['error_info'];
		} else { // 调用 API 成功
			$tracking_detail = $out ['data'] ['tracking_detail'];
			$cond ['tracking_detail'] = $tracking_detail;
			// 分页
			$record_total = $out ['data'] ['total'];
			$page_count = $cond ['page_current'] + 3;
			if (count ( $tracking_detail ) < $limit) {
				$page_count = $cond ['page_current'];
			}
			if (! empty ( $record_total )) {
				$cond ['record_total'] = $record_total;
				$page_count = ceil ( $record_total / $limit );
			}
			$cond ['page_count'] = $page_count;
			$cond ['page'] = $this->pager->getPagerHtml ( $cond ['page_current'], $page_count );
		}
		$cond ['tracking_number'] = $cond ["tracking_number"];
		$cond ['webRoot'] = $this->helper->getUrl ();
		// 把数据 和 系统信息 合并后放到视图中
		$data = $this->helper->merge ( $cond );
		
		$this->load->view ( 'tracking_print_list', $data );
	} // query end
}
?>