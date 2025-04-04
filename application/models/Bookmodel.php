<?php
class Bookmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
       
    }

    // Search books by title or author
    public function search_books($query) {
        // Start building the query
        $this->db->select('*');
        $this->db->from('tblbooks');
        
        // Join the 'tblauthors' table with 'tblbooks' on AuthorId
        $this->db->join('tblauthors', 'tblbooks.AuthorId = tblauthors.id');
        
        // Search condition for title or author
        $this->db->like('BookName', $query);  // Search by book name
        $this->db->or_like('tblauthors.AuthorName', $query);  // Search by author name
        
        // Execute the query
        $query = $this->db->get();
        
        // Return the result as an array of books
        return $query->result_array();
    }
    
    
    // Borrow a book by ID
    public function borrow_book($book_id, $user_id) {
        // Update the book's borrow status and record the borrowing in a 'borrowed_books' table
        $this->db->set('is_borrowed', 1);
        $this->db->set('borrowed_by', $user_id);
        $this->db->where('id', $book_id);
        $this->db->update('book_list');
        
        return array('success' => true, 'message' => 'Book borrowed successfully');
    }

    // Get borrowed books for a user
    public function get_borrowed_books($user_id) {
        $this->db->where('is_borrowed', $user_id);
        $query = $this->db->get('book_list');
        return $query->result_array();
    }
    public function get_book_by_qrcode($qrcode) {
        // Start building the query
        $this->db->select('*');
        $this->db->from('tblbooks');
        
        // Join with the 'tblauthors' table
        $this->db->join('tblauthors', 'tblbooks.AuthorId = tblauthors.id', 'left');  // 'left' join, adjust as necessary
        
        // Filter the query by the QR code
        $this->db->where('HashedQRCodeImageText', $qrcode);  // Adjust to match the QR code column name in your database
        
        // Execute the query
        $query = $this->db->get();
        
        // Check if any result is found
        if ($query->num_rows() > 0) {
            return $query->row_array();  // Return the first matching book row
        } else {
            return null;  // Return null if no matching book is found
        }
    }
    
}
