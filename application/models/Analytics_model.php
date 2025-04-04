<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics_model extends CI_Model {

    // Get the count of books
    public function get_books_count()
    {
        // Use the Query Builder to select the count of books
        $this->db->select('COUNT(*) as count');
        $this->db->from('tblbooks');
        $query = $this->db->get();
        return $query->row()->count;
    }

    // Get the count of not returned books
    public function get_not_returned_count()
    {
        // Use the Query Builder to select the count of not returned books
        $this->db->select('COUNT(*) as count');
        $this->db->from('vwissuedbooks');
        // Use the where method to filter the results, which is safe from SQL injection attacks
        $this->db->where('ReturnStatus', 0);
        $query = $this->db->get();
        return $query->row()->count;
    }

    // Get the count of staff
    public function get_staff_count()
    {
        // Use the Query Builder to select the count of staff
        $this->db->select('COUNT(*) as count');
        $this->db->from('tblstaff');
        $query = $this->db->get();
        return $query->row()->count;
    }

    // Get the count of authors
    public function get_author_count()
    {
        // Use the Query Builder to select the count of authors
        $this->db->select('COUNT(*) as count');
        $this->db->from('tblauthors');
        $query = $this->db->get();
        return $query->row()->count;
    }

    // Get the count of categories
    public function get_category_count()
    {
        // Use the Query Builder to select the count of categories
        $this->db->select('COUNT(*) as count');
        $this->db->from('tblcategory');
        $query = $this->db->get();
        return $query->row()->count;
    }
}