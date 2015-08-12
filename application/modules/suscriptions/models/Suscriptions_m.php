<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suscriptions_m extends MY_Model
{
    public $table        = 'suscriptions'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
    public function __construct()
    {
        $this->soft_deletes = true;
        $this->has_one['customer']   = array('customers/Customers_m','pk_id','fk_customer_id');
        $this->has_one['service']   = array('services/Services_m','pk_id','fk_service_id');
        parent::__construct();
    }           
    
}