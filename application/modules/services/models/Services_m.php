<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services_m extends MY_Model
{
    public $table        = 'services'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
    public function __construct()
    {
        $this->has_many['prices'] = array('Services_prices_m','fk_service_id','pk_id');
        $this->has_many['timebundles'] = array('Services_prices_by_time_m','fk_service_id','pk_id');
        parent::__construct();
    }
    
    public function getUnitPrice( $id ) {
    
        return $this->_database
                    ->query(
                            "SELECT price_amt
                            FROM services_prices
                            WHERE (credits_min_int is null OR credits_min_int <= 1 OR credits_min_int > 1)
                                AND fk_service_id = {$id}
                            ORDER BY credits_min_int
                            LIMIT 1"
                        )->row()->price_amt;
        
    }
    
}