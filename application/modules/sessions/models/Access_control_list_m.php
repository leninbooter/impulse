  <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Access_control_list_m extends MY_Model
{
    public $table        = 'access_control_list'; // you MUST mention the table name
    public $primary_key  = 'pk_id'; // you MUST mention the primary key
    public $fillable     = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected    = array('pk_id'); // ...Or you can set an array with the fields that cannot be filled by insert/update    
    
    public function __construct()
    {               
        parent::__construct();
        $this->soft_deletes = TRUE;
    }
    
    public function getAccessListToGroups($groups) {
        
        $explodedgroups = implode(',', $groups);
        
        return $this->_database
                        ->query("SELECT 
                                    controller_method_ln
                                FROM gi_v2.access_control_list as a
                                inner join access_control_list_groups 
                                on a.pk_id = fk_context_id and fk_group_id in ({$explodedgroups})")->result();
    }
}