<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transactions extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('transactions_m');
    }
        
    public function add( 
                        $transType = false,
                        $suscriptionId = null, 
                        $datetime = false, 
                        $credits_int = null, 
                        $notes = false, 
                        $appointmentId = false,
                        $backTo = false ) {
        
        $this->load->model('suscriptions/suscriptions_m');
        
        switch( $transType ) {
            case 1:
                $this->suscriptions_m->update(
                                            array( 'credits_lock_int' => 'credits_lock_int + ' . abs($credits_int) ), $suscriptionId, FALSE
                                            );
                $id = $this->transactions_m->insert(
                                                    array( 'fk_suscription_id'      => $suscriptionId,
                                                            'datetime_dtm'          => $datetime,
                                                            'notes_txt'             => $notes,
                                                            'fk_appointment_id'     => $appointmentId,
                                                            'fk_transaction_type_id'=> $transType,
                                                            'credits_int'           => $credits_int,
                                                            'pending_ind'           => 1
                                                            )
                                                    );
            break;
            
            case 2:
                if( $suscriptionId ) {
                    $this->suscriptions_m->update(
                                                array( 'credits_lock_int' => 'credits_lock_int - ' . abs($credits_int),
                                                        'credits_used_int' => 'credits_used_int + '.abs($credits_int) ), $suscriptionId, FALSE
                                                );
                }

                if ( $appointmentId != false ) {
                    $credits_int = 0;
                    $parentTransId = $this->transactions_m->where('fk_appointment_id', $appointmentId)->get()->pk_id;
                    $this->transactions_m->update(
                                                array('pending_ind' => 0),
                                                $parentTransId
                                            );
                }
                
                $id = $this->transactions_m->insert(
                                                    array( 'fk_suscription_id'      => $suscriptionId,
                                                            'datetime_dtm'          => $datetime,
                                                            'notes_txt'             => $notes,
                                                            'fk_appointment_id'     => $appointmentId,
                                                            'fk_transaction_type_id'=> $transType,
                                                            'credits_int'           => $credits_int,
                                                            'pending_ind'           => 0
                                                            )
                                                    );
            break;
            
            case 3:
                
                $this->load->model('appointments/Appointments_m');
            
                $apptData = $this->appointments_m->get($appointmentId);
            
                $today = new DateTime("now");
                $apptDate = new DateTime($apptData->datetime_dtm);
                $interval = $today->diff($apptDate);
                
                if ( $interval->days >= 1 ) {
                    
                    $this->suscriptions_m->update(
                                            array( 'credits_lock_int' => 'credits_lock_int - ' . abs($credits_int),
                                                    'credits_used_int' => 'credits_used_int + '.abs($credits_int) ), $suscriptionId, FALSE
                                            );
                    
                    
                }else {
                    
                    $this->suscriptions_m->update(
                                            array( 'credits_lock_int' => 'credits_lock_int - ' . abs($credits_int) ), $suscriptionId, FALSE
                                            );
                }                            

                if ( $appointmentId != false ) {
                    $credits_int = 0;
                    $parentTransId = $this->transactions_m->where('fk_appointment_id', $appointmentId)->get()->pk_id;
                    $this->transactions_m->update(
                                                array('pending_ind' => 0),
                                                $parentTransId
                                            );
                }
                
                $id = $this->transactions_m->insert(
                                                    array( 'fk_suscription_id'      => $suscriptionId,
                                                            'datetime_dtm'          => $datetime,
                                                            'notes_txt'             => $notes,
                                                            'fk_appointment_id'     => $appointmentId,
                                                            'fk_transaction_type_id'=> $transType,
                                                            'credits_int'           => $credits_int,
                                                            'pending_ind'           => 0
                                                            )
                                                    );
            break;
        }
        
        
        
        if ( $id === FALSE ) {
            
        }else {
            if( $backTo ) {
                redirect( $backTo,'refresh');                
            }
        }
    }
}