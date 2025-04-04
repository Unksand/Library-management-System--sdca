<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_model extends CI_Model {

    public function add_program($data)
    {
    $date = new DateTime('now', new DateTimeZone('Asia/Manila')); // Create a new DateTime object with Philippine timezone
    $data['CreationDate'] = $date->format('Y-m-d H:i:s'); // Format the date to Y-m-d H:i:s
    $data['UpdationDate'] = $date->format('Y-m-d H:i:s'); // Format the date to Y-m-d H:i:s
    return $this->db->insert('tblprograms', $data); // Insert data and return result
    }

    public function update_program($id, $data)
    {
    $query = $this->db->query("UPDATE tblprograms SET SchoolCourse = ?, Status = ?, UpdationDate = ? WHERE id = ?", array($data['SchoolCourse'], $data['Status'], $data['UpdationDate'], $id));
    return $query->affected_rows();
    }

    public function delete_program($id)
    {
    $query = $this->db->query("DELETE FROM tblprograms WHERE id = ?", array($id));
    return $query-> affected_rows();
    }

    public function get_program_by_id($id) {
        $query = $this->db->query("SELECT * FROM tblprograms WHERE id = ?", array($id));
        return $query->row();
    }

    public function get_all_programs($limit = null, $offset = null)
    {
        $this->db->select('id, SchoolCourse, Status, CreationDate, UpdationDate');
        $this->db->from('tblprograms');
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_all_programs()
    {
        return $this->db->count_all('tblprograms');
    }
}