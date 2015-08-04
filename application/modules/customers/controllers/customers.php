<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('customerTypes_m');
        $this->load->model('documentTypes_m');
        $this->load->model('countries_m');
    }
    
    public function form( $id = NULL ) {
        
        $this->load->module('layout');
        
        $this->layout->set(
            array(
                'customerTypes' => $this->customerTypes_m->where('parent is null', NULL, NULL, FALSE, FALSE, TRUE)->fields('pk_id, name')->get_all(),
                'documentTypes' => $this->documentTypes_m->as_dropdown('description')->get_all(),
                'countries'     => $this->countries_m->as_dropdown('name')->get_all()
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'customers/form')
            )
        );

        $this->layout->render();
        
    }

}

?>