<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Equipment_m extends MY_Model
{
    public $table        = 'equipment'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
    public function __construct()
    {
        $this->soft_deletes = true;
        
        parent::__construct();
    }
    
    public function getAllWithStats() {
        
        return $this->_database
                    ->query("SELECT 
                                    eq.*,
                                    equ.usagetime
                                FROM {$this->table} as eq
                                LEFT JOIN equipment_usage as equ on equ.fk_equipment_id = eq.pk_id
                                WHERE eq.deleted_at is null")
                    ->result();
    }
   
}