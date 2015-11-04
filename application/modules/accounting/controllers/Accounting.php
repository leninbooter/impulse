<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounting extends MY_Controller 
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
    
    public function addReceivable($custid, $ammount) {
        
        $this->load->model('accounts_receivable_m');
        
        $account = $this->accounts_receivable_m
                ->where("fk_customer_id = {$custid}", null, null, false, false, true)
                ->get();
                
        if ( $account ) {
            log_message('info', 'sumar a deuda');
            $oldbalance = $account->ammount_amt == "" 
                            || $account->ammount_amt ? 0:$account->ammount_amt;
            
            $this->accounts_receivable_m
                ->update(
                array(
                    'ammount_amt' => $oldbalance + $ammount
                ),                
                $account->pk_id
                );
            
        }else {
            log_message('info', 'agregar deuda');
            $this->accounts_receivable_m
                    ->insert(array(
                        'fk_customer_id'    => $custid,
                        'ammount_amt'       => $ammount
                    ));
        }
        
    }
    
}