<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model {

    public function get_all_books() {
        $this->db->select('
            tblbooks.id, 
            tblbooks.BookName, 
            tblbooks.bookImage, 
            tblbooks.QRCodeImage, 
            tblbooks.ISBNNumber, 
            tblbooks.ContentType, 
            tblbooks.Publisher, 
            tblbooks.BookPrice, 
            tblauthors.AuthorName, 
            tblcategory.CategoryName, 
            tblprograms.SchoolCourse AS ProgramName,
            tblbooks.NumberOfCopies
        ');
        $this->db->from('tblbooks');
        $this->db->join('tblauthors', 'tblauthors.id = tblbooks.AuthorId', 'left');
        $this->db->join('tblcategory', 'tblcategory.id = tblbooks.CatId', 'left');
        $this->db->join('tblprograms', 'tblprograms.id = tblbooks.ProgramID', 'left');
        return $this->db->get()->result();
    }
    
    public function get_book_by_id($id) {
        $this->db->select('
            tblbooks.*,
            tblauthors.AuthorName,
            tblcategory.CategoryName,
            tblprograms.SchoolCourse AS ProgramName,
            tblbooks.HashedQRCodeImageText
        ');
        $this->db->from('tblbooks');
        $this->db->join('tblauthors', 'tblauthors.id = tblbooks.AuthorId', 'left');
        $this->db->join('tblcategory', 'tblcategory.id = tblbooks.CatId', 'left');
        $this->db->join('tblprograms', 'tblprograms.id = tblbooks.ProgramID', 'left');
        $this->db->where('tblbooks.id', $id);
        return $this->db->get()->row();
    }
    
    // Insert book and return the inserted ID
    public function insert_book($data) {
        // Hash the QR code image information
        $hashed_qr_code_image_text = hash('sha256', $data['QRCodeImage']);
        
        // Add the hashed QR code image information to the data array
        $data['HashedQRCodeImageText'] = $hashed_qr_code_image_text;
        
        $this->db->insert('tblbooks', $data);
        return $this->db->insert_id();
    }
    
    // Update book information
    public function update_book($id, $data) {
        // Hash the QR code image information
        if (isset($data['QRCodeImage'])) {
            $hashed_qr_code_image_text = hash('sha256', $data['QRCodeImage']);
            $data['HashedQRCodeImageText'] = $hashed_qr_code_image_text;
        }
        
        $this->db->where('id', $id);
        return $this->db->update('tblbooks', $data) === TRUE;
    }
    
    // Delete book
    public function delete_book($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tblbooks');
    }
    
    // Add book (used in the controller add method)
    public function addBook($data) {
        $this->db->insert('tblbooks', $data);
        return $this->db->insert_id(); // Return inserted book ID for QR code handling
    }
    
    // Get book details with QR code (if needed separately for QR code validation/display)
    public function getBookById($book_id) {
        $this->db->where('id', $book_id);
        return $this->db->get('tblbooks')->row_array();
    }
    
    public function get_books_paginated($limit, $offset, $sort_by = 'id', $sort_order = 'desc')
    {
    $this->db->select('
        tblbooks.id, 
        tblbooks.BookName, 
        tblbooks.bookImage, 
        tblbooks.QRCodeImage, 
        tblbooks.ISBNNumber, 
        tblbooks.ContentType, 
        tblbooks.Publisher, 
        tblbooks.BookPrice, 
        tblauthors.AuthorName, 
        tblcategory.CategoryName, 
        tblprograms.SchoolCourse AS ProgramName,
        tblbooks.BookEdition,
        tblbooks.BookLanguage,
        tblbooks.TotalPages,
        tblbooks.YearPublished,
        tblbooks.PlaceOfPublication,
        tblbooks.NumberOfCopies,
        tblbooks.UpdationDate
    ');
    $this->db->from('tblbooks');
    $this->db->join('tblauthors', 'tblauthors.id = tblbooks.AuthorId', 'left');
    $this->db->join('tblcategory', 'tblcategory.id = tblbooks.CatId', 'left');
    $this->db->join('tblprograms', 'tblprograms.id = tblbooks.ProgramID', 'left');
    if ($sort_by == 'ProgramID') {
        $this->db->order_by('tblprograms.SchoolCourse', $sort_order);
    } elseif ($sort_by == 'CreationDate') {
        $this->db->order_by('tblbooks.RegDate', $sort_order);
    } elseif ($sort_by == 'UpdationDate') {
        $this->db->order_by('tblbooks.UpdationDate', $sort_order);
    } elseif ($sort_by == 'none') {
        // Do not apply any sorting
    } else {
        $this->db->order_by($sort_by, $sort_order);
    }
    $this->db->limit($limit, $offset);
    return $this->db->get()->result();
    }
    
    public function count_all_books()
    {
        $this->db->select('
            tblbooks.id, 
            tblbooks.BookName, 
            tblbooks.bookImage, 
            tblbooks.QRCodeImage, 
            tblbooks.ISBNNumber, 
            tblbooks.ContentType, 
            tblbooks.Publisher, 
            tblbooks.BookPrice, 
            tblauthors.AuthorName, 
            tblcategory.CategoryName, 
            tblprograms.SchoolCourse AS ProgramName,
            tblbooks.NumberOfCopies
        ');
        $this->db->from('tblbooks');
        $this->db->join('tblauthors', 'tblauthors.id = tblbooks.AuthorId', 'left');
        $this->db->join('tblcategory', 'tblcategory.id = tblbooks.CatId', 'left');
        $this->db->join('tblprograms', 'tblprograms.id = tblbooks.ProgramID', 'left');
        return $this->db->get()->num_rows();
    }

    // Book_model.php
    public function search_books($search_term, $search_field)
    {
        if ($search_field == 'book_name') {
            $this->db->like('BookName', $search_term);
        } elseif ($search_field == 'author') {
            $this->db->like('AuthorName', $search_term);
        } elseif ($search_field == 'isbn_number') {
            $this->db->like('ISBNNumber', $search_term);
        }
        
        $this->db->select('
            tblbooks.id, 
            tblbooks.BookName, 
            tblbooks.ISBNNumber, 
            tblbooks.bookImage, 
            tblauthors.AuthorName
        ');
        $this->db->from('tblbooks');
        $this->db->join('tblauthors', 'tblauthors.id = tblbooks.AuthorId', 'left');
        $query = $this->db->get();
        return $query->result();
    }
}