<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointments_m extends MY_Model
{
    public $table        = 'appointments'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
    public function __construct()
    {
        $this->soft_deletes = true;
        $this->has_one['suscription']   = array('suscriptions/Suscriptions_m','pk_id','fk_suscription_id');
        parent::__construct();
    }
    
    public function getappt($id) {
        
        return $this->_database
                    ->query("SELECT
                                c.pk_id as cust_id,
                                c.name,
                                c.lastname,
                                se.pk_id as se_id,
                                se.description_ln,
                                appt.datetime_dtm,
                                appt.pk_id,
                                appt.notes_txt,
                                fk_appointment_status_id,
                                apptsts.description_ln as status_description,
                                appt.created_at,
                                appt.fk_suscription_id,
                                appt.cancellation_notes_txt,
                                appt.cancellation_date_dt,
                                appt.credits_int,
                                s.pk_id as suscription_id,
                                appt.fk_attending_employment_id,
                                appt.fk_equipment_id,
                                eq.name_sn as equip_name,
                                concat(us.name, ' ', us.lastname) as attending_employ,
                                appt.fk_service_id,
                                appt.include_accesories_bit,
                                appt.duration_f6_2
                            FROM appointments as appt
                            LEFT JOIN suscriptions          as s ON s.pk_id = appt.fk_suscription_id
                            LEFT JOIN customers             as c ON c.pk_id = appt.fk_customer_id OR s.fk_customer_id  = c.pk_id 
                            LEFT JOIN services              as se ON se.pk_id = appt.fk_service_id OR s.fk_service_id = se.pk_id
                            LEFT JOIN appointments_status   as apptsts ON apptsts.pk_id = appt.fk_appointment_status_id
                            LEFT JOIN equipment             as eq ON appt.fk_equipment_id = eq.pk_id
                            LEFT JOIN users                 as us ON us.pk_id = appt.fk_attending_employment_id
                            WHERE 
                                appt.pk_id = {$id}
                            LIMIT 1
                            ")->row();
    }

    public function getfromto($from, $to) {

        return $this->_database
                    ->query("SELECT
                                c.name,
                                c.lastname,
                                se.description_ln,
                                appt.datetime_dtm,
                                appt.pk_id,
                                appt.fk_appointment_status_id
                            FROM appointments as appt
                            LEFT JOIN suscriptions  as s ON s.pk_id = appt.fk_suscription_id
                            LEFT JOIN customers     as c ON c.pk_id = appt.fk_customer_id  OR c.pk_id = s.fk_customer_id
                            LEFT JOIN services      AS se ON se.pk_id = appt.fk_service_id OR s.fk_service_id = se.pk_id
                            WHERE 
                                appt.datetime_dtm between '{$from}' and '{$to}'
                            ")->result();
    }
    
}