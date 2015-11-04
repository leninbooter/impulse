<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('sales_m');
        $this->load->model('sales_services_items_m');
        $this->load->model('sales_product_items_m');
    }
        
    public function record( $custid, $apptid, $items ) {                               
        
        $id = $this->sales_m->insert(array(
            'fk_customer_id'    => $custid,
            'fk_appointment_id' => $apptid            
        ));
        
        $total = 0;
        
        foreach( $items as $v) {
            
            if( $v['type'] == 1 ) {
                
                $this->sales_services_items_m
                    ->insert(array(
                    
                        'fk_sale_id'            => $id,
                        'fk_item_id'            => $v['itemid'] ,
                        'description_ln'        => $v['description'],
                        'qty_int'               => $v['qty'],
                        'subtotal_ammount_amt'  => $v['price'],
                        'total_amt'             => $v['price'],
                        'unit_price_amt'        => $v['price']
                    ));
                    
                    $total += $v['price'];
            }
            
            if( $v['type'] == 2 ) {
                
                $this->sales_product_items_m
                    ->insert(array(
                    
                        'fk_sale_id'            => $id,
                        'fk_item_id'            => $v['itemid'] ,
                        'description_ln'        => $v['description'],
                        'qty_int'               => $v['qty'],
                        'subtotal_ammount_amt'  => $v['price'],
                        'total_amt'             => $v['price'],
                        'unit_price_amt'        => $v['price']
                    ));
                    
                    $total += $v['price'];
            }
        }
        
        $this->sales_m->update(
                        array(
                            'total_amt' => $total
                        ),
                        $id
                        );
        
        return $id;
    }        
    
}