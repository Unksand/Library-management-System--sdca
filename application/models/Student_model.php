<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

    // Update student status
    public function update_student_status($id, $status)
    {
        $data = ['Status' => $status];
        $this->db->where('id', $id);
        return $this->db->update('tblstudents', $data);
    }

    public function get_all_students($limit, $offset)
    {
    $this->db->select('id, StudentId, FullName, EmailId, MobileNumber, RegDate, Status, SchoolProgram');
    $query = $this->db->get('tblstudents', $limit, $offset);
    return $query->result();
    }

    public function count_all_students()
    {
    $query = $this->db->get('tblstudents');
    return $query->num_rows();
    }

    // Get student history
    public function get_student_history($sid) {
        // Validate and sanitize the sid variable
        $sid = $this->db->escape($sid);

        $this->db->select('tblstudents.StudentId, tblstudents.FullName, tblbooks.BookName, tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate, tblissuedbookdetails.fine');
        $this->db->from('tblissuedbookdetails');
        $this->db->join('tblstudents', 'tblstudents.StudentId = tblissuedbookdetails.StudentId');
        $this->db->join('tblbooks', 'tblbooks.id = tblissuedbookdetails.BookId');
        $this->db->where('tblstudents.StudentId', $sid);
        $query = $this->db->get();
        
        // Debug the query if needed
        log_message('debug', $this->db->last_query());
        
        return $query->result();
    }
}