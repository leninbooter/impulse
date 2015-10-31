<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends MY_Controller 
{
	
	public function __construct()
	{
        $this->requiresAuthentication = false;
        
		parent::__construct();        
        $this->load->helper('url');
	}
    
    public function index()
	{		       
        $this->load->helper('url');
        $this->load->module('sessions');
        
        if ( isset($this->session->user['authenticated']) || $this->session->user['authenticated'] ) {       

            redirect('appointments/todayAppointments');
        }
        
        
        $headData['extraCssFiles']  = $this->load->view(
                                        'html_css_link',  
                                        array(
                                            'files' => array(                                                                 
                                                                base_url('assets/bootstrap-3.3.5-dist/css/bootstrap.min.css'),
                                                                base_url('assets/css/cover.css')
                                                            )
                                            ), 
                                        true);
        $headData['extraJsFiles']   = $this->load->view('html_js_include',  array('files' => array( 
                                                                                                    base_url('assets/jquery-1.11.3.min.js'),
                                                                                                    base_url('assets/login.js')
                                                                                                  )
                                                                                  )
                                                        , true);
        $this->load->view('html_head', $headData);
                      
        $this->load->view('login');
        
        $footData = array();
        $this->load->view('html_foot', $headData);
	}
	
	public function accessdenied() {
        
        
        $this->load->module('layout');
            
        $this->layout->buffer(
            array(
                array('content', 'sessions/access_denied')
            )
        );
            
        $this->layout->render();
    }
    
    public function end() {
        
        session_destroy();
		header('location: '.base_url('index.php/sessions'));
	}
	
	public function start()
	{	
		//$this->output->enable_profiler(true);
		
		$this->benchmark->mark('posts_variables_start');
		$username = trim($this->input->post('email', true));	
		$password = trim($this->input->post('password', true));	
		$this->benchmark->mark('posts_variables_end');
		$this->benchmark->mark('validation_start');
		
        $this->formData = array(
                        array(
                            'field' => $this->input->post('email', true),
                            'label' => 'nombre de usuario',
                            'rules' => 'string_sn'
                        ));
        
        $resArr = array();
        
        if ( !$this->validate() ) {
            
            $resArr['result'] = 'KO';
            $resArr['message'] = $this->validation_errors;
                            
        }else {
            
			$this->load->model('users/users_m');			
			
			$userdata = $this->users_m
                            ->where("username = '{$username}'",
                                    null,
                                    null,
                                    false,
                                    false,
                                    true)
                            ->get();
                            
            
			if( $userdata )
			{				
				$this->benchmark->mark('verify_pwd_start');
                $authenticated = false;
                
                if ( $userdata->pwd == null ) {
                    
                    $this->load->model('users_gi/users_m');
                    
                    $pwd = password_hash($password, PASSWORD_DEFAULT);
                    $this->users_m->updateUser( $userdata->pk_id, false, false, false, false, false, false, $pwd );                    
                    $authenticated = true;
                }else {
                 
                    if(password_verify($password, $userdata->pwd)) {
                        
                        $authenticated = true;
										
                    }                   
                }

                if ( $authenticated ) {                    				
                                        
                    //$this->load->model('users_gi/users_groups_m');
                    $this->load->model('access_control_list_m');
                    $this->load->model('access_control_list_groups_m');
                    $this->load->helper('url');
                    
                    /* $groupsqry = $this->users_groups_m
                                    ->where("fk_user_id = {$userdata->pk_id}", 
                                            null, 
                                            null, 
                                            false, 
                                            false, 
                                            true)
                                    ->get_all();
                    

                    $accesslist = array();
                    $groups = array();
                    
                    foreach( $groupsqry as $k => $v ) {
                        
                        $groups[] = $v->fk_group_id;
                    }
                    
                    if( !empty($groups)) {

                        $accesslistqry = $this->access_control_list_m
                                                ->getAccessListToGroups($groups);
                    
                    

                        foreach( $accesslistqry as $k => $v ) {
                            
                            $accesslist[] = $v->controller_method_ln;
                        }
                    } */
					$user = array(
					   'global_user_id'     => $userdata->pk_id,
					   'username'           => $userdata->username,
					   'authenticated'      => TRUE,
                       'user_full_name'     => $userdata->name.' '.$userdata->lastname,
                       'charge'             => $userdata->charge,
                       'account_type'       => $userdata->fk_user_type_id                       
				    );
					
                    $this->session->user = $user;
                    
                    $return = array( "result"     => "ok",
                                    "redirectTo"=> base_url('index.php')
                                    );
                }else {
                    
                    $return = array("result"=>"KO", "message"=>"¡Contraseña incorrecta!");
                } 
                
			}else {
                
				$return = array("result"=>"KO", "message"=>"El usuario introducido no es válido.");
			}
		}		
		echo json_encode($return);
	
	}
    
    public function hasPrivilegeTo( $context  ) {
        
        if ( !isset($this->session->user['authenticated']) || !$this->session->user['authenticated'] ) {       
            redirect('sessions/index');
        }
        
        $context = explode('/', $context);
        $accessList = $this->session->user['access_list'];
        
        foreach( $accessList as $k => $v ) {
            
            if( $v == $context[0] || $v == $context[0].'/'.$context[1] )
                return true;
            
        }
        return false;
    }

}