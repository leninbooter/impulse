<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_m extends MY_Model
{
    public $table        = 'users'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
     public $rules = array(
        'name' => array('field'=>'name',
                            'label'=>'Nombre',
                            'rules'=>'trim|required'),
        'lastname' => array('field'=>'lastname',
                        'label'=>'Apellido',
                        'rules'=>'trim|required',
                        'errors' => array ( 'trim' => 'Error message for rule "trim" for field email'
                                           )
                        ),
        'charge' => array('field'=>'charge',
                        'label'=>'Cargo',
                        'rules'=>'trim|required',
                        'errors' => array ( 'trim' => 'Error message for rule "trim" for field email'
                                           )
                        ),
        'username' => array('field'=>'username',
                        'label'=>'Nombre de Usuario',
                        'rules'=>'trim|required',
                        'errors' => array ( 'trim' => 'Error message for rule "trim" for field email'
                                           )
                        ),
        'pwd' => array('field'=>'pwd',
                        'label'=>'Contraseña',
                        'rules'=>'trim|required',
                        'errors' => array ( 'trim' => 'Error message for rule "trim" for field email'
                                           )
                        )

    );        
    
    public function __construct()
    {
        $this->has_one['type'] = array('UserTypes_m','pk_id','fk_user_type_id');
        parent::__construct();
    }   

   
    
}