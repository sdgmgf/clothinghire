<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 托盘
class Palletmodel extends CI_Model {

    private $CI;
    private $helper;

    function __construct() {
        parent::__construct();
        if (!isset($this->CI)) {
            $this->CI = & get_instance();
        }
        if (!isset($this->helper)) {
            $this->CI->load->library('Helper');
            $this->helper = $this->CI->helper;
        }
    }

    function getPalletList($params=null){
        return 'hello';
        return $this->helper->get('//',$params);
    }
    
}
