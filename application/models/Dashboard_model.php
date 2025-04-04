<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    /**
     * Get the total count of all books.
     * @return int
     */
    public function get_books_count() {
        // Use the Query Builder to count all books
        return $this->db->count_all('tblbooks'); // Ensure 'tblbooks' exists in your database
    }

    /**
     * Get the count of books not returned.
     * Assumes 'ReturnStatus' column exists and 0 means not returned.
     * @return int
     */
    public function get_not_returned_count() {
        // Use the Query Builder to filter books not returned
        $this->db->where('ReturnStatus', 0); // 0 indicates books not returned
        return $this->db->count_all_results('tblissuedbookdetails'); // Ensure this table exists
    }

    /**
     * Get the count of registered staff (students).
     * @return int
     */
    public function get_staff_count() {
        // Use the Query Builder to count all staff
        return $this->db->count_all('tblstudents'); // Ensure 'tblstudents' exists
    }

    /**
     * Get the count of authors.
     * @return int
     */
    public function get_author_count() {
        // Use the Query Builder to count all authors
        return $this->db->count_all('tblauthors'); // Ensure 'tblauthors' exists
    }

    /**
     * Get the count of categories.
     * @return int
     */
    public function get_category_count() {
        // Use the Query Builder to count all categories
        return $this->db->count_all('tblcategory'); // Ensure 'tblcategory' exists
    }
}