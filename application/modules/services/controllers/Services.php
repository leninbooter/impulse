<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('services_m');        
    }
    
    public function index() {
                
        $this->load->module('layout');
        
        $this->layout->set(
            array(
                'services'     => $this->services_m->with_prices()->get_all()
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'services/index.php')
            )
        );
        
        $this->layout->render();
    }
    
    public function getPricesTable() {
        
        $serviceId = $this->input->get('servId');
        
        $this->load->view('services/prices_table', array( 'prices' => $this->services_m->with_prices()->get($serviceId) ) );
    }
}