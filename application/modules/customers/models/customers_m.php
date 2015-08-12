<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers_m extends MY_Model
{
    public $table        = 'customers'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
    public function __construct()
    {
        $this->has_many['suscriptions'] = 'suscriptions/Suscriptions_m';
        $this->has_many['addresses'] = array('Customer_addresses_m','fk_customer_id','pk_id');
        $this->has_many['contacts'] = array('Customer_contacts_m','fk_customer_id','pk_id');
        parent::__construct();
    }           
    
}