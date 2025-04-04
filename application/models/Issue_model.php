<?php
class Issue_model extends CI_Model
{
    public function issue_book($student_id, $book_id, $is_issued)
    {
        // Validate and sanitize the student_id, book_id, and is_issued variables
        $student_id = $this->db->escape($student_id);
        $book_id = $this->db->escape($book_id);
        $is_issued = $this->db->escape($is_issued);

        // Start transaction
        $this->db->trans_start();

        // Insert into `tblissuedbookdetails`
        $this->db->insert('tblissuedbookdetails', [
            'StudentID' => $student_id,
            'BookId' => $book_id,
        ]);

        // Update `tblbooks` to mark as issued
        $this->db->where('id', $book_id);
        $this->db->update('tblbooks', ['isIssued' => $is_issued]);

        // Commit or rollback transaction
        $this->db->trans_complete();

        return $this->db->trans_status(); // Returns TRUE if successful, FALSE otherwise
    }
}