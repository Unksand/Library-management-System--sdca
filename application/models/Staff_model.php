<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {

    public function get_all_staff($limit, $offset)
    {
    $query = $this->db->get('tblstaff', $limit, $offset);
    return $query->result();
    }

    public function get_staff_count()
    {
        $query = $this->db->get('tblstaff');
        return $query->num_rows();
    }

    public function get_staff_details($sid) {
        // Validate and sanitize the sid variable
        $sid = $this->db->escape($sid);

        $this->db->select('tblstaff.id, tblstaff.SchoolID, tblstaff.FullName, tblstaff.SchoolEmail, tblstaff.PhoneNumber, tblstaff.SchoolProgram, tblstaff.RegDate');
        $this->db->from('tblstaff');
        $this->db->where('tblstaff.id', $sid);
        $query = $this->db->get();
        
        // Debug the query if needed
        log_message('debug', $this->db->last_query());
        
        return $query->row();
    }
}