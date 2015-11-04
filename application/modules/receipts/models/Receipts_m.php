<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receipts_m extends MY_Model
{
    public $table        = 'receipts'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
    public function __construct()
    {
        $this->soft_deletes = true;
        
        parent::__construct();
    }
    
    public function getAllFromCust($custid) {
        
         return $this->_database
                    ->query("
                        SELECT 
                            rec.*                     
                        FROM receipts as rec
                        INNER JOIN sales as sal ON sal.pk_id = rec.fk_sale_id
                        WHERE sal.fk_customer_id = {$custid}
                    ")->result();
    }
    
    public function pay( $id, $ammount ) {
        
        $this->_database
            ->query(
                "UPDATE {$this->table}
                    SET paid_amt = paid_amt + {$ammount},
                        balance_amt = balance_amt - {$ammount}
                    WHERE pk_id = {$id} LIMIT 1
                    "
            );
    }
    
}