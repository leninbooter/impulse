<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointments extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('appointments_m');
    }       

    public function add() {
        
        $this->load->module('transactions');
        
        $id = $this->appointments_m->insert(
                array( 'fk_suscription_id'  => $this->input->post('suscription')['id'],
                        'credits_int'       => 1,
                        'datetime_dtm'      => DateTime::createFromFormat('m/d/Y', $this->input->post('appointment')['fecha'])->format('Y-m-d '.$this->input->post('appointment')['hora']) )
            );
        
        if ( $id === FALSE ) {                        
            
        }else {
            
            $this->transactions->add(
                                    1,
                                    $this->input->post('suscription')['id'], 
                                    date('Y-m-d H:i:s'), 
                                    -1, 
                                    "Reservación de cita", 
                                    $id
                                );
            
            redirect('suscriptions/actives','refresh');
        }
    }
    
    public function last10Appts( $custId = false, $layout = true ) {
        
        
    }
    
    public function todayAppointments() {
        
        $this->load->module('layout');
        $this->load->model('suscriptions/Suscriptions_m');
        
        $appointments = $this->appointments_m->with_suscription()->get_all();
        
        for( $i=0; $i<count($appointments); $i++) {
            $appointments[$i]->customer = 
            $this->suscriptions_m->with_customer()->get($appointments[$i]->fk_suscription_id)->customer;
            
            $appointments[$i]->service = 
            $this->suscriptions_m->with_service()->get($appointments[$i]->fk_suscription_id)->service;
        }

        $this->layout->set(
            array(
                'appointments'          => $appointments,
                'custom_css'            => array(base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar/fullcalendar.min.css')),
                'custom_js'             => array(
                                                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',                                                
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/fullcalendar.min.js'),
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/lang/es.js')
                                                )
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'appointments/table_today_appointments.php')
            )
        );
        
        $this->layout->render();
    }
    
    public function cancel() {
        
        $this->load->model('suscriptions/Suscriptions_m');
        $this->load->module('transactions');
        
        $apptId = $this->input->post('apptId');
        
        $affected = $this->appointments_m->update(
                                                    array(  'fk_appointment_status_id'       => 3 ),
                                                    $apptId        
                                                );
                                                
        $apptData = $this->appointments_m->get($apptId);
        $suscId = $apptData->fk_suscription_id;                
        
        $this->transactions->add(
                                    3,
                                    $suscId, 
                                    date('Y-m-d H:i:s'), 
                                    $apptData->credits_int, 
                                    "Cancelación cita", 
                                    $apptId                                    
                                );
                                
        redirect( 'appointments/todayAppointments', 'refresh' );
    }
    
    public function checkin() {
        
        $this->load->model('suscriptions/Suscriptions_m');
        $this->load->module('transactions');
        
        $apptId = $this->input->post('apptId');
        
        $affected = $this->appointments_m->update(
                                                    array(  'fk_appointment_status_id'       => 5 ),
                                                    $apptId        
                                                );
                                                
        $apptData = $this->appointments_m->get($apptId);
        $suscId = $this->appointments_m->get($apptId)->fk_suscription_id;
        
        $this->transactions->add(
                                    2,
                                    $suscId, 
                                    date('Y-m-d H:i:s'), 
                                    $apptData->credits_int, 
                                    "Atención de cita para servicio", 
                                    $apptId                                    
                                );
        redirect( 'appointments/todayAppointments', 'refresh' );
    }
    
    public function getApptsFromTo() {            

        $this->load->model('suscriptions/Suscriptions_m');
    
        if ( isset($_GET["start"]) && isset($_GET["end"]) ) {
                
            $start = DateTime::createFromFormat('Y-m-d', $_GET["start"])->format('Y-m-d 00:00:00');
            $end   = DateTime::createFromFormat('Y-m-d', $_GET["end"])->format('Y-m-d 00:00:00');
            $events = $this->appointments_m->with_suscription()->where("datetime_dtm between {$start} and {$end}")->get_all();
            
            for( $i=0; $i<count($events); $i++) {
                $events[$i]->customer = 
                $this->suscriptions_m->with_customer()->get($events[$i]->fk_suscription_id)->customer;
                
                $events[$i]->service = 
                $this->suscriptions_m->with_service()->get($events[$i]->fk_suscription_id)->service;
            }
                                                                        
        }else {
            echo "bad format";
        }
        header('Content-type: application/json');
        
        $jsonArr = array();
        foreach( $events as $ev ) {
            
            array_push( $jsonArr , array( "title" => $ev->customer->name." ".$ev->customer->lastname." - ".$ev->service->description_ln,
                                          "start" => $ev->datetime_dtm,
                                          "citaID" => $ev->pk_id,
                                          "name"    => $ev->customer->name." ".$ev->customer->lastname,
                                          "startFormatted"    => DateTime::createFromFormat('Y-m-d H:i:s',$ev->datetime_dtm)->format('j \d\e M - G:i'),
                                          "serviceName" => $ev->service->description_ln )
                        );
        }    
        echo json_encode( $jsonArr );
    }
}