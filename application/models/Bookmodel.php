<?php
class Bookmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
       
    }

    // Search books by title or author
    public function search_books($query) {
        // Select the relevant fields, including BookImage
        $this->db->select('tblbooks.*, tblauthors.AuthorName, tblbooks.bookImage');
        $this->db->from('tblbooks');
        $this->db->join('tblauthors', 'tblbooks.AuthorId = tblauthors.id');
        $this->db->like('BookName', $query);
        $this->db->or_like('tblauthors.AuthorName', $query);
        
        $query = $this->db->get();
        
        // Assuming images are stored in a folder like /uploads/books/
        $result = $query->result_array();
        foreach ($result as &$book) {
            // If BookImage is not empty, append the path
            if (!empty($book['bookImage'])) {
                $book['BookImage'] = base_url('http://localhost/login/assets/bookimg/' . $book['bookImage']);
            }
        }
        
        return $result;
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
        $this->db->select('tblbooks.*, tblauthors.*, tblbooks.bookImage');  // Specify columns to select, including bookImage
        
        $this->db->from('tblbooks');
        
        // Join with the 'tblauthors' table
        $this->db->join('tblauthors', 'tblbooks.AuthorId = tblauthors.id', 'left');  // Left join for author details
        
        // Filter the query by the QR code
        $this->db->where('HashedQRCodeImageText', $qrcode);  // Adjust to match the QR code column name in your database
        
        // Execute the query
        $query = $this->db->get();
        
        // Check if any result is found
        if ($query->num_rows() > 0) {
            // Fetch the result as an associative array
            $book = $query->row_array();
    
            // Assuming 'bookImage' is the image filename or relative path in the database
            // Base URL for images
            $base_url = 'http://localhost/login/assets/bookimg/';
            
            // Construct the full image URL and assign it to the 'bookImage' key
            $book['bookImage'] = $base_url . $book['bookImage'];  // Construct the full URL for the image
    
            return $book;  // Return the book data including the full image URL
        } else {
            return null;  // Return null if no matching book is found
        }
    }
    
    
    
}
