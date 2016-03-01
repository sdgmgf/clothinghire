<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ProductPurchaseUser extends CI_Controller {
	function __construct()
	{
		     
      date_default_timezone_set("Asia/Shanghai");
		parent::__construct();
    	$this->load->library('session'); 
        $this->load->library('Excel');
        $this->load->library('Pager'); 
        $this->load->model('productmodel');
        $this->load->model('common');
	}


  public function index() {
    $area_id = $this->getInput('area_id');
    $data=array();
    if(empty($area_id)){
	    $out = $this->productmodel->getProductPurchaseUserList('default');     
    }else {
        $out = $this->productmodel->getProductPurchaseUserList($area_id);
    }

  	if (isset($out['error_info'])) {
  		die("错误" . $out['error_info']);
  	}
    $data = $this->helper->merge($out);
    $this->load->view('product_purchase_user',$data);
  }
  
  public function update() {
 
  	$cond = array(
  		"purchase_user_id" => $this->getInput("hidden_user_id"),
  		"product_id" => $this->getInput("hidden_product_id"),
  		"area_id" => $this->getInput("hidden_area_id"),
  	);
  	$out = $this->productmodel->updateProductPurchase($cond);
  	if (isset($out['error_info'])) {
  		echo $out['error_info'];
  		die();
  	}
  	$this->index();
  }

    public function getAreaList(){
        $out = $this->common->getUserAreaList();
        if(!empty($out)){
            echo json_encode(array('success'=>'success', 'area_list'=>$out['data']));
        }else{
            echo json_encode(array('success'=>'fail', 'error_info'=>$out['error_info']));
        }
    }
  
  // 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			return $out;
		}
		$out = trim($out);
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
