<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Respect\Validation\Validator as v;

class MY_Controller extends MX_Controller 
{
    protected $formData                 = array();    
    protected $validation_errors        = "";
    protected $publicAccess             = true;
    protected $requiresAuthentication   = true;
    
    function __construct() {
        
        parent::__construct();
        
        $this->checkAccess();
    }
    
    private function checkAccess() {
        
        $this->load->helper('url');
        $this->load->module('sessions');
        
        
        if( $this->requiresAuthentication ) {
        
            if( $this->publicAccess ) {
                
                if ( !isset($this->session->user['authenticated']) || !$this->session->user['authenticated'] ) {       

                    redirect('sessions/index');
                }
            }else {
                        
                $context = "{$this->router->class}/{$this->router->method}";
                if( !$this->sessions->hasPrivilegeTo($context) ) {
                    
                    redirect('sessions/accessdenied');
                }
            }
        }
    }
    
    protected function validate() {
        
        //$this->validation_errors = "<ul>";
        
        foreach( $this->formData as $k => $v ) {
            
            $isValid = true;
            switch( $v['rules'] ) {
                
                case 'numeric':                    
                    $isValid = v::numeric()->validate( $v['field'] );
                    
                break;
                
                case 'integer':                    
                    $isValid = v::int()->validate( $v['field'] );
                    
                break;
                
                case 'string_st':
                    $isValid = v::string()->length(2,25)->validate( $v['field'] );
                break;
                
                case 'string_ln':
                    $isValid = v::string()->length(2,50)->validate(  $v['field'] );
                break;
            }
            
            if ( !$isValid ) {
                
                if ( isset($v['cust_mess']) ) {
                    $message = "{$v['cust_mess']}";
                }else {
                    $message = "Por favor, introduzca un valor válido para el campo de {$v['label']}";
                }
                
                $this->validation_errors = $message;
                return false;
            }                        
        }
        
        return true;
    }
}