<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('services_m');        
        $this->load->model('services_prices_by_time_m');        
        $this->load->model('services_prices_m');        
    }
    
    public function add() {        
        
        $name           = $this->input->post('name', true);
        $creditsfrom    = $this->input->post('creditsfrom', true);
        $creditsto      = $this->input->post('creditsto', true);
        $creditsprice   = $this->input->post('creditsprice', true);
        
        $timesbundle    = $this->input->post('time', true);
        $bundleprice   = $this->input->post('timebundleprice', true);
        $timebundleappts   = $this->input->post('timebundleappts', true);
        
        $observations   = $this->input->post('observations', true);
        
        $id = $this->input->post('serviceid', true);
        if( $id ) {
            
            if( $this->input->post('remove') ) {
                
                $this->services_prices_m
                        ->where("fk_service_id = {$id}", null, null, false, false, true)
                        ->delete();
                        
                $this->services_prices_by_time_m
                        ->where("fk_service_id = {$id}", null, null, false, false, true)
                        ->delete();
                        
                $this->services_m->delete($id);
                
            }else {
                
                // Edit  
                
                // Credits            
                $creditsid    = $this->input->post('credid', true);
                
                $savedCred = $this->services_prices_m
                                    ->where("fk_service_id = {$id}", null, null, false, false, true )
                                    ->get_all();
                
                $updated = array();
                
                for( $i = 0; $i < count($creditsfrom) ; $i++ ) {
                    
                    if( isset($creditsid[$i]) ) {
                        
                        $this->services_prices_m
                            ->update(
                                array(
                                    'credits_min_int'   => $creditsfrom[$i],
                                    'credits_max_int'   => $creditsto[$i],
                                    'price_amt'         => $creditsprice[$i]
                                ),
                                $creditsid[$i]
                            );
                            $updated[$creditsid[$i]] = true;
                    }else {
                        
                         $this->services_prices_m
                            ->insert(array(
                                'fk_service_id'     => $id,
                                'credits_min_int'   => $creditsfrom[$i],
                                'credits_max_int'   => $creditsto[$i],
                                'price_amt'         => $creditsprice[$i]
                            ));
                        
                    }
                }
                
                if ( $savedCred ) {
                    foreach( $savedCred as $sc ) {
                        
                        if( !isset($updated[$sc->pk_id]) ) {
                            
                            $this->services_prices_m->delete($sc->pk_id);
                            
                        }
                        
                    }
                }
                // Price by time
                $ids    = $this->input->post('timeid', true);
                
                $saved = $this->services_prices_by_time_m
                                    ->where("fk_service_id = {$id}", null, null, false, false, true )
                                    ->get_all();
                
                $updated = array();
                
                for( $i = 0; $i < count($timesbundle) ; $i++ ) {
                    
                    if( isset($ids[$i]) ) {
                        
                        $this->services_prices_by_time_m
                            ->update(
                                array(
                                    'time_bundle_int'   => $timesbundle[$i],
                                    'price_amt'         => $bundleprice[$i],
                                    'month_appts_int'         => $timebundleappts[$i]
                                ),
                                $ids[$i]
                            );
                            $updated[$ids[$i]] = true;
                    }else {
                        
                         $this->services_prices_by_time_m
                            ->insert(array(
                                'fk_service_id'     => $id,
                                'time_bundle_int'   => $timesbundle[$i],
                                'price_amt'         => $bundleprice[$i],
                                'month_appts_int'         => $timebundleappts[$i]
                            ));
                        
                    }
                }
                               
                if ( $saved ) {
                    foreach( $saved as $sc ) {
                        
                        if( !isset($updated[$sc->pk_id]) ) {
                            
                            $this->services_prices_by_time_m->delete($sc->pk_id);
                            
                        }
                        
                    }
                }
                $this->services_m->update(
                array(
                'description_ln'    => $name,
                'observations_txt'  => $observations
                ),
                $id
                );
            }
            
           
            
            redirect("services", 'refresh');
            
        }else {
            
            // New
            $id = $this->services_m
                ->insert(array(
                    'description_ln'    => $name,
                    'observations_txt'  => $observations
                ));
                
            for($i=0; $i<count($creditsfrom); $i++) {
                
                $this->services_prices_m
                        ->insert(array(
                            'fk_service_id'     => $id,
                            'credits_min_int'   => $creditsfrom[$i],
                            'credits_max_int'   => $creditsto[$i],
                            'price_amt'         => $creditsprice[$i]
                        ));
            }
            
            for($i=0; $i<count($timesbundle); $i++) {
                
                $this->services_prices_by_time_m
                        ->insert(array(
                            'fk_service_id'     => $id,
                            'time_bundle_int'   => $timesbundle[$i],
                            'price_amt'         => $bundleprice[$i],
                            'month_appts_int'   => $timebundleappts[$i]
                        ));
            }
            
            redirect("services/addedsuccess", 'refresh');
        }
        
    }
    
    public function addedsuccess() {
        
        $this->load->module('layout');
         
        $this->layout->buffer(
            array(
                array('content', 'services/newaddedsuccess')
            )
        );
        
        $this->layout->render('layout_confirms');
    }
    
    public function index() {
                
        $this->load->module('layout');
        
        $this->layout->set(
            array(
                'services'     => $this->services_m->with_prices()->with_timebundles()->get_all()
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'services/index.php')
            )
        );
        
        $this->layout->render();
    }
    
    public function form( $id = null ) {
        
        $this->load->module('layout');
                
        $savedservice = array();
        
        if( $id ) {            
            
            $service = $this->services_m->get($id);
            $credits = $this->services_prices_m
                            ->where("fk_service_id = {$id}", null, null, false, false, true)
                            ->get_all();
            
            $timbundles = $this->services_prices_by_time_m
                            ->where("fk_service_id = {$id}", null, null, false, false, true)
                            ->get_all();
            
            $savedservice = array(
                            'service'   => $service,
                            'credits'   => $credits,
                            'timebundles'   => $timbundles
                        );
        }        
        
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
                                        ->view( 'form', 
                                                $savedservice, 
                                                true),
                
                'title'         => !$id ? 'Nuevo Servicio' : 'Editar Servicio'
            )
        );   

        
        
        $this->layout->buffer(
            array(
                array('content', 'services/new_service')
            )
        );
        
        $this->layout->render();
    }
    
    public function getPricesTable() {
        
        $serviceId = $this->input->get('servId');
        
        $this->load->view('services/prices_table', array( 'prices' => $this->services_m->with_prices()->get($serviceId) ) );
    }
}