<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MX_Controller 
{

    function __construct() {
        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('users_m');        
    }
    
    /**
     * 
     * Maneja los datos de un usuario/empleado. Muestra el formulario vacío si no se recibio 
     * la petición POST; en caso contrario, valida y registra el usuario.
     * 
     * @param <type> $id  
     * 
     * @return <type>
     */
    public function form( $id = NULL ) {
        
        $this->load->module('layout');
        
        if ($this->input->post('btn_guardar')) { // Si POST
            
            $id = $this->users_m->from_form()->insert();
            
            if ( $id === FALSE ){
                echo "Error de validación";
            }else {
                echo "Usuario creado satisfactoriamente";
            }
            
        }else { // Si no, mostrar el formulario vacío para nuevo usuario
            
            $this->layout->buffer(
            array(
                    array('content', 'users/form')
                )
            );

            $this->layout->render();
        }
        
        //$this->layout->set();       
    }
    
    public function show() {
        
        $user = $this->users_m->with_type()->get(1);
        var_dump($user);
        echo $user->type->name;
    }
}

?>