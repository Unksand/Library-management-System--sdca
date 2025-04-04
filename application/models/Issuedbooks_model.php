<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issuedbooks_model extends CI_Model
{
    public function get_issued_book_details($rid)
    {
        // Validate and sanitize the rid variable
        $rid = $this->db->escape($rid);

        $this->db->select('tblstudents.StudentId, tblstudents.FullName, tblstudents.EmailId, 
                           tblstudents.MobileNumber, tblbooks.BookName, tblbooks.ISBNNumber, 
                           tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate, 
                           tblissuedbookdetails.id as rid, tblissuedbookdetails.fine, 
                           tblissuedbookdetails.RetrunStatus, tblbooks.id as bid, tblbooks.bookImage');
        $this->db->from('tblissuedbookdetails');
        $this->db->join('tblstudents', 'tblstudents.StudentId = tblissuedbookdetails.StudentId');
        $this->db->join('tblbooks', 'tblbooks.id = tblissuedbookdetails.BookId');
        $this->db->where('tblissuedbookdetails.id', $rid);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function return_book($rid, $fine, $rstatus, $bookid)
    {
        // Validate and sanitize the rid, fine, rstatus, and bookid variables
        $rid = $this->db->escape($rid);
        $fine = $this->db->escape($fine);
        $rstatus = $this->db->escape($rstatus);
        $bookid = $this->db->escape($bookid);

        // Update the issued book details and book status in a transaction
        $this->db->trans_start();
        $this->db->set('fine', $fine);
        $this->db->set('RetrunStatus', $rstatus);
        $this->db->where('id', $rid);
        $this->db->update('tblissuedbookdetails');

        $this->db->set('isIssued', 0);
        $this->db->where('id', $bookid);
        $this->db->update('tblbooks');
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_all_issued_books()
    {
    $this->db->select('tblissuedbookdetails.id as rid, tblstudents.FullName, tblbooks.BookName, 
                       tblbooks.ISBNNumber, tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate');
    $this->db->from('tblissuedbookdetails');
    $this->db->join('tblstudents', 'tblstudents.StudentId = tblissuedbookdetails.StudentId');
    $this->db->join('tblbooks', 'tblbooks.id = tblissuedbookdetails.BookId');
    $query = $this->db->get();

    return $query->result();
    }

    public function count_all_issued_books()
    {
    $this->db->select('tblissuedbookdetails.id as rid, tblstudents.FullName, tblbooks.BookName, 
                       tblbooks.ISBNNumber, tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate');
    $this->db->from('tblissuedbookdetails');
    $this->db->join('tblstudents', 'tblstudents.StudentId = tblissuedbookdetails.StudentId');
    $this->db->join('tblbooks', 'tblbooks.id = tblissuedbookdetails.BookId');
    $query = $this->db->get();

    return $query->num_rows();
    }

}