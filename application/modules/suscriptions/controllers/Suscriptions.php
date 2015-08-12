<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suscriptions extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('suscriptions_m');
    }
    
    public function actives( $custId = false, $layout = true ) {
        
        $this->load->module('layout');
        $this->load->model('customers/customers_m');
        $this->load->model('services/services_m');
        
        $customerId = $custId === false ? $this->input->get('custId'):$custId;        
        
        $this->layout->set(
            array(
                'customerData'          => $this->customers_m->get($customerId),
                'suscriptions'          => $this->suscriptions_m->with_service()->where('fk_customer_id', $customerId)->get_all(),
                'formAddSuscription'    => $this->load->view('form_new_suscriptions', array( 'services' => $this->services_m->as_dropdown('description_ln')->get_all(),
                                                                                            'customerId' => $customerId ), true),
                'formAddAppointment'    => $this->load->view('appointments/form_new_appointment', '', true)
            )
        );
        
        if ( $layout ) {
        
            $this->layout->buffer(
                array(
                    array('content', 'suscriptions/actives_of_customer.php')
                )
            );
            
            $this->layout->render();
        
        }else {
            
            return $this->load->view('suscriptions/actives_of_customer', $this->layout->view_data, true);
        }
        
    }   

    public function add() {
        
        $this->load->model('services/services_prices_m');
        
        $customerId = $this->input->post('suscription')['customerId'];
        
        $serviceId = $this->input->post('suscription')['serviceId'];
        
        $credits = $this->input->post('suscription')['credits'];
        
        $redirect = $this->input->post('redirect');
        
        $price = $this->services_prices_m->where(array('fk_service_id' => $serviceId ,
                                                             'credits_min_int <=' => $credits,
                                                             'credits_max_int >= ' => $credits ))->get();
        
        if ( empty($price) ) {
            
            $price = $this->services_prices_m->where( "fk_service_id = {$serviceId} and {$credits} >= credits_min_int and (credits_max_int is null or credits_max_int = 0)",null,null,false, false, true)->get();        
        }
        
        $price = $price->price_amt;
        
        $id = $this->suscriptions_m->insert(
                array( 'fk_customer_id' => $customerId,
                        'fk_service_id' => $serviceId,
                        'credits_int'   => $credits,
                        'credits_lock_int' => 0, 
                        'credits_used_int' => 0,
                        'price_amt'         => $price
                        )
            );
        
        if ( $id === FALSE ) {
            
        }else {
            redirect($redirect, 'refresh');
        }
    }
    
    public function heldCreditsFrom() {
        
        $this->load->module('layout');
        $this->load->model('transactions/transactions_m');
        
        $suscriptionId = $this->input->get('s');
        $suscriptionData = $this->suscriptions_m->with_customer()->with_service()->get($suscriptionId);
        
        $this->layout->set(
            array(
                'customerData'          => $suscriptionData->customer,
                'service'               => $suscriptionData->service,
                'transactions'          => $this->transactions_m->where(array('fk_suscription_id' =>  $suscriptionId,
                                                                                'pending_ind' => 1 ))->get_all()
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'suscriptions/held_credits_from.php')
            )
        );
        
        $this->layout->render();
        
    }
    
    public function usedCreditsFrom() {
        
        $this->load->module('layout');
        $this->load->model('transactions/transactions_m');
        
        $suscriptionId = $this->input->get('s');
        $suscriptionData = $this->suscriptions_m->with_customer()->with_service()->get($suscriptionId);
        
        $this->layout->set(
            array(
                'customerData'          => $suscriptionData->customer,
                'service'               => $suscriptionData->service,
                'transactions'          => $this->transactions_m->where(array('fk_suscription_id' =>  $suscriptionId,
                                                                                'pending_ind' => 0 ))->get_all()
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'suscriptions/used_credits_from.php')
            )
        );
        
        $this->layout->render();
        
    }
}