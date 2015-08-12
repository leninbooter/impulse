<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers extends MX_Controller 
{

    function __construct() {
                        
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('Customertypes_m');
        $this->load->model('Documenttypes_m');
        $this->load->model('countries_m');
        $this->load->model('customers_m');
    }
    
    public function index() {
        
        $this->load->module('layout');
        
        $this->layout->set(
            array(
                'customers'     => $this->customers_m->fields(
                                                            'pk_id, name, lastname'
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
                array('content', 'customers/index.php')
            )
        );
        
        $this->layout->render();
    }
    
    public function form( $customerId = NULL, $layout = true ) {
                 
        if ( $this->input->post('btnSubmit') ) {
           
           $this->load->model('Customer_addresses_m');
           $this->load->model('Customer_contacts_m');
           
           $picture = isset($this->input->post('customer')['picture']) 
                        && $this->input->post('customer')['picture'] ? $this->input->post('customer')['']:'';
           
           $customer = array(
                                'name'              => $this->input->post('customer')['name'],
                                'lastname'          => $this->input->post('customer')['lastname'],
                                'fk_document_type'  => $this->input->post('customer')['documentType'],
                                'NIF'               => $this->input->post('customer')['document'],
                                'telephone'         => $this->input->post('customer')['phone'],
                                'mobile'            => $this->input->post('customer')['mobile'],
                                'email'             => $this->input->post('customer')['email'],
                                'picture'           => $picture,
                                'fk_customer_type'  => $this->input->post('customer')['type']
                                );
            $customerId = $this->customers_m->save($customerId, $customer);               
            
            // Directions
            $updatedDir = array();
            
            $dirdesc = $this->input->post('dirdesc');
            $dirviatype = $this->input->post('dirviatype');
            $dirvia = $this->input->post('dirvia');
            $dirportal = $this->input->post('dirportal');
            $dirfloor = $this->input->post('dirfloor');
            $dirlocality = $this->input->post('dirlocality');
            $dircp = $this->input->post('dircp');
            $dirprovince = $this->input->post('dirprovince');
            $dircountry = $this->input->post('dircountry');
            $dirId = $this->input->post('dirId');
            
            for( $i = 0; $i < count($dirdesc) ; $i++ ) {
                
                $direction = array(
                                    'fk_customer_id' => $customerId,
                                    'description'    => $dirdesc[$i],
                                    'via_type'       => $dirviatype[$i],
                                    'via'            => $dirvia[$i],
                                    'portal'         => $dirportal[$i],
                                    'floor'          => $dirfloor[$i],
                                    'locality'       => $dirlocality[$i],
                                    'CP'             => $dircp[$i],
                                    'province'       => $dirprovince[$i],
                                    'fk_country_id'  => $dircountry[$i] 
                                );
                $pk_id = NULL;
                if ( isset( $dirId[$i] ) ) {
                    $pk_id = $dirId[$i];
                }

                $updatedDir[$this->Customer_addresses_m->save($pk_id, $direction)] = true;
            }       
            $savedDir = $this->Customer_addresses_m->where('fk_customer_id', $customerId )->get_all();
            foreach( $savedDir as $sDir ) {
                
                if( !isset($updatedDir[$sDir->pk_id]) ) {
                    $this->Customer_addresses_m->delete($sDir->pk_id);
                }
                
            }
            
            // Contacts            
            $updatedCon = array();
            
            $contactdesc = $this->input->post('contactdesc');
            $contactname = $this->input->post('contactname');
            $contactlastname = $this->input->post('contactlastname');
            $contactphone = $this->input->post('contactphone');
            $contactmobile = $this->input->post('contactmobile');
            $contactemail = $this->input->post('contactemail');
            
            for( $i = 0; $i < count($contactdesc) ; $i++ ) {
                
                $contact = array(
                                    'fk_customer_id' => $customerId,
                                    'description'    => $contactdesc[$i],
                                    'name'       => $contactname[$i],
                                    'lastname'            => $contactlastname[$i],
                                    'telephone'         => $contactphone[$i],
                                    'mobile'          => $contactmobile[$i],
                                    'email'       => $contactemail[$i]
                                    );
                                    
                $pk_id = NULL;
                if ( isset( $conId[$i] ) ) {
                    $pk_id = $conId[$i];
                }

                $updatedCon[$this->Customer_contacts_m->save($pk_id, $contact)] = true;
            }
            
            $savedCon = $this->Customer_contacts_m->where('fk_customer_id', $customerId )->get_all();
            foreach( $savedCon as $cDir ) {
                
                if( !isset($updatedCon[$cDir->pk_id]) ) {
                    $this->Customer_contacts_m->delete($cDir->pk_id);
                }
                
            }

            redirect(base_url('index.php/customers'));
        }
        
        $layoutArray = array(
                            'customerTypes' => $this->Customertypes_m
                                                    ->where(
                                                            'parent is null', 
                                                            NULL, 
                                                            NULL, 
                                                            FALSE, 
                                                            FALSE, 
                                                            TRUE)
                                                    ->fields('pk_id, name')
                                                    ->set_cache('get_customers_types',0)
                                                    ->get_all(),
                            'documentTypes' => $this->Documenttypes_m
                                                    ->as_dropdown('description')
                                                    ->set_cache('get_doc_types')
                                                    ->get_all(),
                            'countries'     => $this->countries_m
                                                    ->as_dropdown('name')
                                                    ->set_cache('get_countries',0)
                                                    ->get_all()
                        );
        
        if ( $customerId ) {
            
            $layoutArray['userData']  = $this->customers_m
                                                ->with_addresses()
                                                ->with_contacts()
                                                ->get($customerId);
                            
        }

        $this->load->module('layout');
        
        $this->layout->set( $layoutArray );
        
        if ( $layout ) {            
            
            $this->layout->buffer(
                array(
                    array('content', 'customers/form')
                )
            );

            $this->layout->render();
            
        }else {
            
            return $this->load->view('customers/form', $this->layout->view_data, true);
            
        }     
        
    }

}

?>