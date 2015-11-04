<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('products');
    }   

    public function index() {
        
        
    }
    
}