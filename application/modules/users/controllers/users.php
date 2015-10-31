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
    
    public function index() {
        
        $this->load->module('layout');
        
        $this->layout->set(
            array(
                'users'     => $this->users_m->with_type()->fields(
                                                            'pk_id, name, lastname, charge, created_at'
                                                            )->get_all(),
                'custom_js'     => array(
                                        base_url('assets/AdminLTE-2.2.0/plugins/datatables/jquery.dataTables.min.js'),
                                        base_url('assets/AdminLTE-2.2.0/plugins/datatables/dataTables.bootstrap.js')
                                        ),
                'custom_css'     => array(
                                        base_url('assets/AdminLTE-2.2.0/plugins/datatables/dataTables.bootstrap.css')
                                        
                                        )
            )
        );
        
        $this->layout->buffer(
            array(
                array('content', 'users/index.php')
            )
        );
        
        $this->layout->render();
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
    public function form( $id = NULL, $layout = true ) {
        
        $this->load->model("usertypes_m");
       
        
        if ( $this->input->post('btn_guardar') ) {                     
           
           $user = array(
                                'name'              => $this->input->post('name'),
                                'lastname'          => $this->input->post('lastname'),
                                'charge'            => $this->input->post('charge'),
                                'fk_user_type_id'   => $this->input->post('fk_document_type'),
                                'username'          => $this->input->post('username')                                
                                );
            $user['pwd'] = password_hash($this->input->post('pwd'), PASSWORD_DEFAULT);
            $id = $this->users_m->save($id, $user);                                       

            redirect(base_url('index.php/users'));
        }
        
        $layoutArray = array(
                            'userTypes'     => $this->usertypes_m                                                    
                                                    ->as_dropdown('name')
                                                    ->set_cache('get_users_types',0)
                                                    ->get_all()
                            );
                
        
        if ( $id ) {
            
            $layoutArray['userData']  = $this->users_m->get($id);
                            
        }

        $this->load->module('layout');
        
        $this->layout->set( $layoutArray );
        
        if ( $layout ) {            
            
            $this->layout->buffer(
                array(
                    array('content', 'users/form')
                )
            );

            $this->layout->render();
            
        }else {
            
            return $this->load->view('users/form', $this->layout->view_data, true);
            
        }    
    }
    
    public function show() {
        
        $user = $this->users_m->with_type()->get(1);
        var_dump($user);
        echo $user->type->name;
    }
}

?>