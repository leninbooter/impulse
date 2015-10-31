<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payments extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('payments_m');
    }
            
    
}