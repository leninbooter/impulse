<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessions_m extends CI_Model
{		
	var $db;

	function __construct()
	{
		parent::__construct();
		
		$this->db = $this->load->database('default', true);
	}
	
	function sel_user_data($username)
	{
		$query = 'select 
                    cr.pk_id, 
                    cr.username,
                    cr.password,
                    cr.name,
                    cr.lastname,
                    p.name as profile_name,
                    p.pk_id as profile_id
				from credentials as cr
                    inner join profiles as p on p.pk_id = cr.fk_profile_id				                    
				where cr.username = \''.$username.'\'';
				
		$query = $this->db->query($query);
        $result = $query->result();
		return !empty($result) ? $query->row() : array();
	}
}