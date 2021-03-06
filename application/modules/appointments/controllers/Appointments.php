<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointments extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('appointments_m');
    }       

    public function add($ajax = null) {
        
        $ajax = filter_var($ajax, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        
        $this->load->module(array('transactions', 'customers'));
        $this->load->model('suscriptions/suscriptions_m');
        
        $datetime_dtm    = DateTime::createFromFormat('Y-m-d\TH:i:s', $this->input->post('apptdate', true))->format('Y-m-d H:i');
        $c = $this->input->post('customer', true);
        $s = $this->input->post('service', true);
        $obs = $this->input->post('observations', true);
        $newcustname = $this->input->post('name', true);
        $newcustlastname = $this->input->post('lastname', true);
        $newcustphone = $this->input->post('telephone', true);
        
        if( !is_numeric($c) ) {
            
            $customer = array(
                                'name'              => $newcustname,
                                'lastname'          => $newcustlastname,
                                'fk_document_type'  => null,
                                'NIF'               => null,
                                'telephone'         => $newcustphone,
                                'mobile'            => $newcustphone,
                                'email'             => null,
                                'picture'           => null,
                                'fk_customer_type'  => 2
                                );
            
            $c = $this->customers_m->save(null, $customer);   
        }
        
        $qry = $this->suscriptions_m
                    ->where("fk_customer_id = {$c} AND fk_service_id = {$s}", null,null, false, false, true)
                    ->get();
        
        if ( !$qry ) {
            
            // No suscription
            $id = $this->appointments_m->insert(
                array(  'fk_service_id'  => $s,
                        'fk_customer_id' => $c,
                        'datetime_dtm'   => $datetime_dtm ,
                        'fk_appointment_status_id'  => 6,
                        'notes_txt'     => $obs
                        )
            );
            
            if ( $id === FALSE ) {                        
            
            }else {
                
                 $this->transactions->add(
                                        1,
                                        null, 
                                        date('Y-m-d H:i:s'), 
                                        0, 
                                        "Reservación de cita", 
                                        $id
                                    );
            }
            
            //redirect("appointments/addednosusc/{$id}",'refresh');
            
        }else {
            
            // Suscribed
            $id = $this->appointments_m->insert(
                array(  'fk_suscription_id' => $qry->pk_id,
                        'credits_int'       => 1,
                        'datetime_dtm'      => $datetime_dtm,
                        'fk_appointment_status_id'  => 6,
                        'notes_txt'     => $obs
                        )
            );
            
            if ( $id === FALSE ) {                        
            
            }else {
                
                 $this->transactions->add(
                                        1,
                                        $qry->pk_id, 
                                        date('Y-m-d H:i:s'), 
                                        -1, 
                                        "Reservación de cita", 
                                        $id
                                    );
            }
            
            //redirect("appointments/addedwithsusc/{$id}",'refresh');
        }
        
        if ( $ajax ) {
            
            echo json_encode(array(
                'result'    => 'OK'
            ));
        }else {
        
            redirect("appointments/todayappointments",'refresh');
        }
    }
    
    public function addednosusc() {
                
        $this->load->module('layout');
         
        $this->layout->buffer(
            array(
                array('content', 'appointments/addednosusc.php')
            )
        );
        
        $this->layout->render('layout_confirms');
    }
    
    public function addedwithsusc() {
        
          $this->load->module('layout');
         
        $this->layout->buffer(
            array(
                array('content', 'appointments/addedwithsusc.php')
            )
        );
        
        $this->layout->render('layout_confirms');
    }
    
    public function edit( $id = null ) {
        
        $this->load->module('layout');
        $this->load->model('customers/customers_m');                
        $this->load->model('services/services_m');                
        
        $appt = $this->appointments_m->getappt( $id );
        
        $pickedDate = DateTime::createFromFormat('Y-m-d H:i:s', $appt->datetime_dtm);
                
        $this->layout->set(
            array(                
                'custom_css'        => array(   base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar/fullcalendar.min.css'),
                                                base_url('assets/select2-4.0.0/dist/css/select2.min.css')
                                            ),
                
                'custom_js'         => array(
                                                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',                                                
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/fullcalendar.min.js'),
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/lang/es.js'),
                                                base_url('assets/select2-4.0.0/dist/js/select2.full.min.js'),
                                                base_url('assets/select2-4.0.0/dist/js/i18n/es.js')
                                                ),
                                                
                'services'         => $this->services_m->get_all(),
                
                'customers'         => $this->customers_m->get_all(),
                
                'pickedDay'         => $pickedDate->format('d/m/Y'),
                
                'pickedTime'        => $pickedDate->format('H:i'),
                
                'appt'              => $appt
            )
        );        
        
        $this->layout->buffer(
            array(
                array('content', 'appointments/form_new')
            )
        );
        
        $this->layout->render('layout_empty');
    }
    
    public function last10Appts( $custId = false, $layout = true ) {
        
        
    }
    
    public function todayAppointments() {
        
        $this->load->module(array('layout', 'customers', 'services'));
        $this->load->model('suscriptions/suscriptions_m');
        
       /*  $appointments = $this->appointments_m->with_suscription()->get_all();
        
        if ( $appointments ) {
            
            for( $i=0; $i<count($appointments); $i++) {
                $appointments[$i]->customer = 
                $this->suscriptions_m->with_customer()->get($appointments[$i]->fk_suscription_id)->customer;
                
                $appointments[$i]->service = 
                $this->suscriptions_m->with_service()->get($appointments[$i]->fk_suscription_id)->service;
            }
        } */
        $this->layout->set(
            array(
                'custom_css'            => array(base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar/fullcalendar.min.css'),
                                                base_url('assets/select2-4.0.0/dist/css/select2.min.css'),
                                                base_url('assets/magiccss/magic.min.css')
                                                ),
                'custom_js'             => array(
                                                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',                                                
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/fullcalendar.min.js'),
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/lang/es.js'),
                                                base_url('assets/select2-4.0.0/dist/js/select2.full.modified.js'),
                                                base_url('assets/select2-4.0.0/dist/js/i18n/es.js')
                                                ),
                'customers'     => $this->customers_m->get_all(),
                'services'      => $this->services_m->get_all()
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
    
    public function checkout($id = null) {                
        
        echo $this->load->view(
                'checkout',
                array(
                    'apptid'  => $id
                ),
                true
            );
    }
    
    public function confirm() {
        
        
    }
    
    public function create() {
        
        $this->load->module('layout');
        $this->load->model('customers/customers_m');                
        $this->load->model('services/services_m');                
        
        $pickedDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $this->input->get('apptdate'));       
                
        $this->layout->set(
            array(                
                'custom_css'        => array(   base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar/fullcalendar.min.css'),
                                                base_url('assets/select2-4.0.0/dist/css/select2.min.css')                                                
                                            ),
                
                'custom_js'         => array(
                                                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',                                                
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/fullcalendar.min.js'),
                                                base_url('assets/AdminLTE-2.2.0/plugins/fullcalendar-2.3.2/lang/es.js'),
                                                base_url('assets/select2-4.0.0/dist/js/select2.full.min.js'),
                                                base_url('assets/select2-4.0.0/dist/js/i18n/es.js')
                                                ),                                                             
                'form'          =>  $this->load
                                        ->view( 'form_new', 
                                                array(
                                                       'services'         => $this->services_m->get_all(),
                                                        'customers'         => $this->customers_m->get_all(),
                                                        'pickedDay'         => $pickedDate->format('d/m/Y'),
                                                        'pickedTime'        => $pickedDate->format('H:i'),
                                                ), 
                                                true)
            )
        );        
        
        $this->layout->buffer(
            array(
                array('content', 'appointments/new_appointment.php')
            )
        );
        
        $this->layout->render();
        
    }
    
    public function getApptsFromTo() {            

        $this->load->model('suscriptions/suscriptions_m');
    
        $colors = array(
            '1' => '#337AB7',
            '2' => '#5BC0DE',
            '3' => '#D9534F',
            '4' => '#337AB7',
            '5' => '#5CB85C',
            '6' => '#777777',
            '7' => '#5CB85C'
        );                
        
    
        if ( isset($_GET["start"]) && isset($_GET["end"]) ) {
                
            $start = DateTime::createFromFormat('Y-m-d', $_GET["start"])->format('Y-m-d 00:00:00');
            $end   = DateTime::createFromFormat('Y-m-d', $_GET["end"])->format('Y-m-d 00:00:00');
            $events = $this->appointments_m->getfromto($start, $end);            
                                                                        
        }else {
            echo "bad format";
        }
        header('Content-type: application/json');
        
        $jsonArr = array();
        foreach( $events as $ev ) {
            
            array_push( $jsonArr , array( "title"               => $ev->name." ".$ev->lastname." - ".$ev->description_ln,
                                          "start"               => $ev->datetime_dtm,
                                          "citaID"              => $ev->pk_id,
                                          "name"                => $ev->name." ".$ev->lastname,
                                          "startFormatted"      => DateTime::createFromFormat('Y-m-d H:i:s',$ev->datetime_dtm)->format('j \d\e M - G:i'),
                                          "serviceName"         => $ev->description_ln,
                                          'backgroundColor'     => $colors[$ev->fk_appointment_status_id],
                                          'borderColor'     => $colors[$ev->fk_appointment_status_id]
                                        )
                        );
        }    
        echo json_encode( $jsonArr );
    }
    
    private function recordSale( $apptid ) {
        
        $this->load->module('services');
        $this->load->model('suscriptions/suscriptions_m');        
        $this->load->model('products/products_m');        
        $this->load->module('sales');        
        $this->load->module('customers');        
        
        $appt = $this->appointments_m->getappt($apptid);
        
        $price = 0;
        $products = array();
        
        if ( $appt->fk_suscription_id ) {
            
            $price = $this->suscriptions_m
                            ->fields('price_amt')
                            ->get($appt->fk_suscription_id);
                            
            if( !$price->price_amt ) {
                $price = 0;
            }
            
        }elseif( $appt->fk_service_id ) {

            $price = $this->services_m
                            ->getUnitPrice( $appt->fk_service_id );
            
        }else {
            
            return false;
        }
        
        if( $appt->include_accesories_bit == 1 ) {
            
            $products[] = $this->products_m
                                ->get();
        }
        
        $s          = $this->services_m->get($appt->se_id);
        $cust       = $this->customers_m->get( $appt->cust_id );
        $cust_addrs = $this->customer_addresses_m->getOf($appt->cust_id);
        
        $items = array();
        
        $items[] = array(
            'type'          => '1', // Service
            'itemid'        => $s->pk_id,
            'qty'           => 1,
            'description'   => $s->description_ln,
            'price'         => $price
        );
        
        if( isset($products) && !empty($products)) {
            
            foreach($products as $v) {
                
                $items[] = array(
                    'type'          => '2', // Product
                    'itemid'        => $v->pk_id,
                    'qty'           => 1,
                    'description'   => $v->description_sn,
                    'price'         => $v->price_amt
                );
            }
        }
        
        return $this->sales->record(
                                        $appt->cust_id,
                                        $apptid,
                                        $items
                                    );                

    }
    
    public function setwhoattend() {
        
        $apptid = $this->input->post('appt');
        $emplid = $this->input->post('employees');
        
        $this->appointments_m->update(
            array(
                'fk_attending_employment_id' => $emplid                
            ),
            $apptid
        );
        
        echo json_encode(array(
            'result' => 'OK'
        ));
    }   
    
    public function save( $id = null ) {
        
        $this->load->module('transactions');
        $this->load->model('suscriptions/suscriptions_m');
        
        $id = $id ? $id:$this->input->post('apptid');
        
        // Set as attended
        if ( $this->input->post('attended') ) {            
            
            $this->load->model('suscriptions/suscriptions_m');
            $this->load->module('equipment');
            
            $duration = $this->input->post('duration', true);
            
            $appt = $this->appointments_m->get($id);
            $resultArr = array();
            
            $this->appointments_m
                ->update(    array(
                                'duration_f6_2' => $duration,
                                'fk_appointment_status_id' => 5
                            ), 
                            $id);
            
            if ( $appt->fk_suscription_id == null ) {
                
                // Without suscription
                
                $this->load->module('transactions');   
                
                $affected = $this->appointments_m
                                    ->update(
                                        array(  'fk_appointment_status_id'       => 5 ),
                                        $id        
                                    );
                                                        
                $apptData = $this->appointments_m->getappt($id);
                
                $this->transactions->add(
                                            2,
                                            null, 
                                            date('Y-m-d H:i:s'), 
                                            null, 
                                            "Atención en servicio ({$apptData->description_ln})", 
                                            $id                                    
                                        );
                
                $resultArr = array(
                    'result'    => 'OK'
                );
                
            }else {
                
                // Suscription
                $this->load->module('transactions');                
                
                $affected = $this->appointments_m
                                    ->update(
                                        array(  'fk_appointment_status_id'       => 5 ),
                                        $id        
                                    );
                                                        
                $apptData = $this->appointments_m->getappt($id);
                
                $this->transactions->add(
                                            2,
                                            $apptData->suscription_id, 
                                            date('Y-m-d H:i:s'), 
                                            $apptData->credits_int, 
                                            "Atención en servicio ({$apptData->description_ln})", 
                                            $id                                    
                                        );
                
                $resultArr = array(
                    'result'    => 'OK'
                );
            }
            
            $resultArr['saleid'] = $this->recordSale( $id );
            
            $this->equipment->addStat( $apptData->fk_equipment_id, $apptData->duration_f6_2 );
            
            echo json_encode($resultArr);
            return;
        }
        
        // Set patient arrived
        if ( $this->input->post('checkin') ) {                        
            
            $emplid = $this->input->post('employees');
            $machineid = $this->input->post('machines', true);
            $accesories = $this->input->post('accesories', true);
            
            $this->appointments_m
                ->update(    array(
                                'fk_appointment_status_id'  => 7,
                                'fk_attending_employment_id'=> $emplid,
                                'fk_equipment_id'           => $machineid,
                                'include_accesories_bit'    => $accesories ? 1:0
                            ), 
                            $id);
                            
            redirect("",'refresh');
        }
        
        // Confirm         
        if ( $this->input->post('confirm') ) {            
            
            $this->appointments_m
                ->update(    array(
                                'fk_appointment_status_id' => 1
                            ), 
                            $id);
                            
            redirect("appointments/view/{$id}",'refresh');
        }
        
        // Cancel
        if ( $this->input->post('cancel') ) {                       
            
            $this->appointments_m
                ->update(    array(
                                'fk_appointment_status_id' => 3,
                                'cancellation_notes_txt'    => $this->input->post('cancellationnote'),
                                'cancellation_date_dt'      => date('Y-m-d H:i:s')
                            ), 
                            $id);
                            
            redirect("appointments/view/{$id}",'refresh');
        }
        
        // Modify
        if ( $this->input->post('save') ) {
          
            $datetime_dtm = DateTime::createFromFormat('d/m/Y', $this->input->post('date', true))->format('Y-m-d '.$this->input->post('time'));
            $c = $this->input->post('customer', true);
            $s = $this->input->post('service', true);
            $obs = $this->input->post('observations', true);
            
            $qry = $this->suscriptions_m
                        ->where("fk_customer_id = {$c} AND fk_service_id = {$s}", null,null, false, false, true)
                        ->get();
            
            $appt = $this->appointments_m->get($id);
            
            if ( !$qry ) {
                
                // No suscription
                
                $updArr = array(  'fk_service_id'  => $s,
                            'fk_customer_id' => $c,
                            'datetime_dtm'   => $datetime_dtm ,
                            'notes_txt'     => $obs
                            );
                
                if ( $appt->datetime_dtm != $datetime_dtm ) {
                    
                    $updArr['fk_appointment_status_id'] = 4;
                }
                
                $this->appointments_m->update( $updArr, $id );
                
                redirect("appointments/view/{$id}",'refresh');
                
            }else {
                
                // Suscribed                
                $updArr = array(  'fk_suscription_id' => $qry->pk_id,
                            'datetime_dtm'      => $datetime_dtm,
                            'notes_txt'     => $obs
                            );
                
                if ( $appt->datetime_dtm != $datetime_dtm ) {
                    
                    $updArr['fk_appointment_status_id'] = 4;
                }
                
                $this->appointments_m->update( $updArr, $id );
                
                redirect("appointments/view/{$id}",'refresh');
            }
            
            return;
        }
        
        
        
        
    }
    
    public function view( $id = 0 ) {
        
        $this->load->module('layout');
        $this->load->model('users/users_m');
        $this->load->model('equipment/equipment_m');
        
        $appt = $this->appointments_m->getappt( $id );
        $appt->datetime_dtm = DateTime::createFromFormat('Y-m-d H:i:s', $appt->datetime_dtm)->format('d-m-Y H:i');
        $datetimearr = explode(" ", $appt->datetime_dtm);
        $employees = $this->users_m->get_all();
        $machines   = $this->equipment_m->get_all();
        
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
                'appt'          => $appt,
                'datetimearr'   => $datetimearr,
                'employees'     => $employees,
                'machines'      => $machines
            )
        );
        
        if ( $appt->fk_appointment_status_id == 5 ) {
            
            $this->load->module(array('sales', 'payments'));
            
            $sale = $this->sales_m
                        ->where(    "fk_appointment_id = {$appt->pk_id}", 
                                    null, 
                                    null, 
                                    false, 
                                    false, 
                                    true)
                        ->get();
            
            $payments  = $this->payments_m
                                        ->with_method()
                                        ->where("fk_sale_id = {$sale->pk_id}", null, null, false, false, true)
                                        ->get_all();
            
            $payments = !$payments ? array():$payments;
            
            $this->layout->set(array(
            
                    'products'  =>  $this->sales_product_items_m
                                        ->where("fk_sale_id = {$sale->pk_id}", null, null, false, false, true)
                                        ->get_all(),
                                        
                    'services'  => $this->sales_services_items_m
                                        ->where("fk_sale_id = {$sale->pk_id}", null, null, false, false, true)
                                        ->get_all(),
                    'subtotal'  => 0,
                    
                    'total'     => 0,
                    
                    'saleid'    => $sale->pk_id,
                    
                    'payments'  => $payments
            ));
        }
        
        $this->layout->buffer(
        
            array(
                array('content', 'appointments/view')
            )
        );
        
        $this->layout->render();
        
    }
}