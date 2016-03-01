<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class Region extends CI_Controller {
	function __construct()
	{
		parent::__construct();
    $this->load->library('session'); 
    $this->load->library('RestApi'); 
	}

  /**
   *  get 请求 
   * @param  [type] $path   [description]
   * @param  array  $fields [description]
   * @return [type]         [description]
   */
  private function get($path,$fields=array()){
    return json_decode(
      $this->restapi->call("get",$path,$fields),
      true
      );
  }

   private function getJson($path,$fields=array()){
    return   $this->restapi->call("get",$path,$fields);
  }

  public function provinceList(){
    // 获取中国的所有省 
    $data = $this->getCity(1); 
    echo  json_encode($data);
  }
  
  public function cityList(){
    $parent_id = $this->input->get('parent_id');
    if(empty($parent_id)){
       $data['OK'] = true;
       echo  json_encode($data) ;
       return; 
    }
     // 获取该省份下的所有市 
    $data = $this->getCity($parent_id ); 
    echo  json_encode($data);
  }
  
  public function getRegionId(){
  	$region_name = $this->input->post('region_name');
//   	echo $region_name;die();
  	if(empty($region_name)){
  		echo json_decode(array("region_id"=>-1));
  	}
  	$data=$this->getRegionByName($region_name);
  	echo json_encode($data);die();
  }
  
  private function getRegionByName($region_name){
  	$data = $this->get("/regions/regionByName",array('region_name'=>$region_name)); 
  	if(!isset($data['region'])){
  		$data['OK'] = false;
  	}else{
  		$data['OK'] = true;
  	}
  	return $data;
  }
  
  private function getCity($parent_id){
     $out = $this->get("/regions",array('parent_id'=>$parent_id)); 
    if(!isset($out['regions'])){
      $data['OK'] = false;
    }else{
       $data['data'] = $out['regions'];
       $data['OK'] = true;
    }
    return $data; 
  }
   
   

   
    
    

}
?>