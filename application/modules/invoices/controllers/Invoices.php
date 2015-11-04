<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoices extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('invoices_m');
    }
        
    public function invoice( $saleid, $modal = false ) {
        
        $modal = filter_var($modal, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        
        $this->load->module('sales');
        $this->load->module('customers');
        
        $sale = $this->sales_m->get($saleid);
        
        $products          = $this->sales_product_items_m
                                ->where("fk_sale_id = {$saleid}", null, null, false, false, true)
                                ->get_all();                                
                                
        $services          = $this->sales_services_items_m
                                ->where("fk_sale_id = {$saleid}", null, null, false, false, true)
                                ->get_all();
                                
                                
        $cust       = $this->customers_m->get( 
            $sale->fk_customer_id );
        $cust_addrs = $this->customer_addresses_m->getOf(
            $sale->fk_customer_id);
        
        $invoiceDataArr = array(
                                    'saleid'          => $saleid,
                                    'cust'          => $cust,
                                    'cust_addrs'    => $cust_addrs,
                                    'services'       => $services,
                                    'products'      => $products,
                                    'subtotal'      => 0,
                                    'total'         => 0
                                );
        
        if( $modal ) {
            
            $form = $this->load
                        ->view( 'form', 
                                $invoiceDataArr,
                                true);
            
            echo $this->load->view(
                'modalcontentinvoice',
                array(
                    'form'  => $form
                ),
                true
            );
            
        }else {
        
            echo $this->load
                        ->view( 'form', 
                                $invoiceDataArr,
                                true);
        }
    }
        
    public function generate() {
        
        $this->load->model('payments/payments_m');
        $this->load->module('sales');
        
        $custid = $this->input->post( 'custid', true);
        $saleid = $this->input->post( 'saleid', true);
        $notes = $this->input->post( 'notes', true);
        
        $sale = $this->sales_m->get($saleid);
        
        $pm = $this->input->post( 'paymentmeth', true);
        $payment_notes = $this->input->post( 'payment_description', true);
        $payment_ammount = $this->input->post( 'payment_ammount', true);
        $payment_ammount = $payment_ammount == "" ? 0:$payment_ammount;
    
        $balance = $sale->total_amt - $payment_ammount;
        
        if ( $payment_ammount > 0 && $pm != 3 ) {
        
            $this->payments_m
                    ->insert(array(
                                'fk_sale_id'            => $saleid,
                                'ammount_amt'           => $payment_ammount,
                                'fk_payment_method_id'  => $pm,
                                'note_txt'              => $payment_notes
                            ));
        }
        
        if( $pm == 3 || $balance > 0 ){
            
            $this->load->module('accounting');
            
            $this->accounting
                ->addReceivable(   
                                $sale->fk_customer_id, 
                                $balance );
        }
        $invid = $this->invoices_m
                        ->insert(
                            array(
                                'fk_sale_id'            => $saleid,
                                'subtotal_amt'          => $sale->total_amt, 
                                'total_amt'             => $sale->total_amt,
                                'paid_amt'              => $payment_ammount,
                                'balance_amt'           => $balance,
                                'notes_txt'             => $notes
                            )
                        );               
        
        $this->sales_m->update(
            array(
                'billed_bit'    => 1
            ),
            $saleid
        );
        
        
        redirect("",'refresh');
    }
    
    public function pay($id = null, $saleid = null, $ammount) {
        
        $this->invoices_m->pay($id, $ammount);
    }
}