<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
    }  
    
    public function userForm( $id = NULL ) {
        
        $this->load->module("users");
        
        $this->load->module('layout');
        
        $this->layout->set(
            array(
                'sectionTittle' => "Nuevo Empleado/Usuario",
                'userForm'  => $this->users->form($id, false)
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'dashboard/new_user_form')
            )
        );

        $this->layout->render();
        
    }
    
    public function customerProfile( $id = NULL ) {
        
        $this->load->module('layout');
        //$this->load->module('customers');
        $this->load->module('suscriptions');
        $this->load->module('customers');
        $this->load->model('customers/customers_m');       
        
        $customerdata = $this->customers_m->get($id);
        
        $this->layout->set(
            array(
                'sectionTittle' => $customerdata->name." ". $customerdata->lastname,
                'customerForm'  => $this->customers->form($id, false),
                'bonus'         => $this->suscriptions->actives( $id, false ),
                'lastAppts'     => ''
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'dashboard/customer_profile')
            )
        );

        $this->layout->render();
    
    }
    
}