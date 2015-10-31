<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounting extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('accounting_m');
    }   

    public function index() {
        
        $this->load->model('payments/payments_m');
        
        $this->load->module('layout');
        
        $this->layout->set(
        
            array(
                'custom_css'            => array(
                                                    base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar/fullcalendar.min.css'),
                                                    base_url('assets/select2-4.0.0/dist/css/select2.min.css'),
                                                    base_url('assets/magiccss/magic.min.css')
                                                ),
                'custom_js'             => array(
                                                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',                                                
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/fullcalendar.min.js'),
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/lang/es.js'),
                                                base_url('assets/select2-4.0.0/dist/js/select2.full.min.js')
                                                ),
                                                
                'transactions'  => $this->accounting_m->getPayments()
            )
        );
        
        $this->layout->buffer(
        
            array(
                array('content', 'accounting/cashbook')
            )
        );
        
        $this->layout->render();
    }
    
}