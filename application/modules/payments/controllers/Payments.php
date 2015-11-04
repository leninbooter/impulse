<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payments extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('payments_m');
    }
    
    public function add() {
            
        $recid             = $this->input->post('recid', true);
        $recid             = $recid || $recid != "" ? $recid: null;
                
        $invid              = $this->input->post('invid', true);
        $invid              = $invid || $invid != "" ? $invid: null;
        
        $payment_ammount    = $this->input->post('payment_ammount', true);
        $pm                 = $this->input->post('paymentmeth', true);
        $payment_notes      = $this->input->post('payment_description', true);                                                 
                
        $saleid  = $this->input->post('saleid', true);
        
        if ( !$saleid ) {
        
            if( $invid ) {
            
                $this->load->module('invoices');
                
                $saleid = $this->invoices_m->fields("fk_sale_id")
                    ->get($invid)->fk_sale_id;
                
                $this->invoices
                    ->pay(
                        $invid, 
                        $saleid,
                        $payment_ammount
                    );
                    
               
            }
            
            if( $recid ) {
            
                $this->load->module('receipts');
            
                $saleid = $this->receipts->field("fk_sale_id")
                    ->get($recid);
            
                $this->receipts
                    ->pay(
                        $recid,
                        $saleid,
                        $payment_ammount
                    );
                    
                
            }
        }
        
        $this->payments_m
                    ->insert(array(
                                'fk_sale_id'            => $saleid,
                                'ammount_amt'           => $payment_ammount,
                                'fk_payment_method_id'  => $pm,
                                'note_txt'              => $payment_notes
                            ));
            
        echo json_encode(array(
            'result'    => 'OK'
        ));
        
    }
    
}