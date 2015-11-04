<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Equipment extends MY_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('equipment_m');
        $this->load->model('equipment_usage_m');
    }   

    public function form($id = null) {
            
        $this->load->module('layout');
        
        if ( $this->input->post('save') ) {
            
            $serial = $this->input->post('serial', true);
            $name = $this->input->post('name', true);
            $desc = $this->input->post('description', true);
            
            if ( $id ) {
                
                $this->equipment_m
                ->update(array(
                    'serial_ln' => $serial,
                    'name_sn' => $name,
                    'description_txt' => $desc,
                ),
                $id);
                
            }else {
                
                $this->equipment_m
                ->insert(array(
                    'serial_ln' => $serial,
                    'name_sn' => $name,
                    'description_txt' => $desc,
                ));
            }                                    
            
                
            redirect('equipment', 'refresh');
        }
        
        $formDataArr = array();
                        
        if( $id ) {            
                        
            $formDataArr = array(
                'eq'    => $this->equipment_m->get($id)
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
                                                $formDataArr, 
                                                true),
                
                'title'         => !$id ? 'Nuevo Equipo' : 'Editar Equipo'
            )
        );   

        
        
        $this->layout->buffer(
            array(
                array('content', 'equipment/new')
            )
        );
        
        $this->layout->render();
    }
    
    public function index() {
        
        $equipment = $this->equipment_m->getAllWithStats();
        
        $totalusage = 0;
        foreach($equipment as $v) {
            $totalusage += $v->usagetime;
        }
        
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
                'equipment'             => $equipment,
                'totalusage'            => $totalusage
                
            )
        );
        
        $this->layout->buffer(
        
            array(
                array('content', 'equipment/index')
            )
        );
        
        $this->layout->render();
    }
    
    public function addStat( $eqid, $time ) {
       
       $stat = $this->equipment_usage_m
                ->where("fk_equipment_id = {$eqid}", null, null, false, false, true)
                ->limit(1)
                ->get();
                
       if( $stat  ) {
            
            $this->equipment_usage_m
                    ->update(
                    array(
                        'usagetime' => $stat->usagetime + $time
                    ),
                    $eqid);
        }else {
            
            $this->equipment_usage_m
                ->insert(array(
                    'fk_equipment_id'   => $eqid,
                    'usagetime'         => $time
                ));
        }
    }
    
}