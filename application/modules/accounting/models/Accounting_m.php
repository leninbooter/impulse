<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Accounting_m extends MY_Model
{
    public $table        = ''; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
    public function __construct()
    {
        $this->soft_deletes = true;
        
        parent::__construct();
    }
    
    public function getPayments() {
        
        return $this->_database
                    ->query("
                        SELECT
                            pay.*,
                            inv.pk_id as invoice_id
                        FROM        payments as pay
                        INNER JOIN sales as sa ON sa.pk_id = pay.fk_sale_id
                        LEFT JOIN invoices as inv ON inv.fk_sale_id = sa.pk_id
                        LEFT JOIN receipts as rec ON rec.fk_sale_id = sa.pk_id
                    ")
                    ->result();
    }
}