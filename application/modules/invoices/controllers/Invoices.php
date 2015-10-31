<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoices extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('invoices_m');
    }
        
    public function invoice( $id = 0 ) {
        
        $this->load->model('appointments/appointments_m');
        $this->load->model('customers/customers_m');
        $this->load->model('customers/customer_addresses_m');
        $this->load->model('services/services_m');
        $this->load->model('services/services_prices_m');        
        
        $appt = $this->appointments_m->getappt($id);
        
        $s          = $this->services_m->get($appt->se_id);
        $price      = $this->services_m->getUnitPrice($appt->se_id);
        $cust       = $this->customers_m->get($appt->cust_id);
        $cust_addrs = $this->customer_addresses_m->getOf($appt->cust_id);
        
        echo $this->load
                    ->view( 'form', 
                            array(
                                'appt'          => $appt,
                                'cust'          => $cust,
                                'cust_addrs'    => $cust_addrs,
                                'service'       => $s,
                                'servicePrice'  => $price
                            ),
                            true);
    }
        
    public function generate() {
        
        $this->load->model('invoice_items_m');
        $this->load->model('payments/payments_m');
        
        $apptid = $this->input->post( 'apptid', true);
        $custid = $this->input->post( 'custid', true);
        $itemsqty = $this->input->post( 'itemqty', true);
        $itemid = $this->input->post( 'itemid', true);
        $itmdesc = $this->input->post( 'itmdesc', true);
        $subtotal = $this->input->post( 'subtotal', true);
        $total = $this->input->post( 'total', true);
        $pm = $this->input->post( 'paymentmeth', true);
        
        $invid = $this->invoices_m
                        ->insert(
                            array(
                                'fk_customer_id'        => $custid,
                                'fk_invoice_status_id'  => 1,
                                'subtotal_amt'          => $subtotal, 
                                'total_amt'             => $total,
                                'paid_amt'              => $total,
                                'balance_amt'           => 0
                            )
                        );
        
        for( $i=0; $i<count($itemsqty); $i++ ) {
            
            $this->invoice_items_m
                    ->insert(array(
                        'fk_invoice_id'         => $invid,
                        'fk_item_id'            => $itemid[$i],
                        'description_ln'        => $itmdesc[$i],
                        'qty_int'               => $itemsqty[$i],
                        'subtotal_ammount_amt'  => $subtotal ,
                        'total_amt'             => $total
                    ));
            
        }

        $this->payments_m
                ->insert(array(
                            'fk_invoice_id'         => $invid,
                            'ammount_amt'           => $total,
                            'fk_payment_method_id'  => $pm[0]
                        ));
        
        redirect("",'refresh');
    }
    
}