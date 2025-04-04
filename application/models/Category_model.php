<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{

    public function add_category($data)
    {
        $data['CreationDate'] = date('Y-m-d H:i:s'); // Add current timestamp
        $data['UpdationDate'] = date('Y-m-d H:i:s'); // Add current timestamp
        return $this->db->insert('tblcategory', $data); // Insert data and return result
    }

    public function delete_category($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblcategory');
    }
    
    public function get_category_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tblcategory')->row_array();
    }

    public function update_category($id, $data)
    {
    $data['UpdationDate'] = date('Y-m-d H:i:s'); // Add current timestamp
    $this->db->where('id', $id);
    return $this->db->update('tblcategory', $data); // Returns true/false
    }

    public function get_all_categories($limit = null, $offset = null) {
        $this->db->select('
            tblcategory.id, 
            tblcategory.CategoryName, 
            tblcategory.Status, 
            tblcategory.CreationDate, 
            tblcategory.UpdationDate
        ');
        $this->db->from('tblcategory');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    
    public function count_all_categories()
    {
        $this->db->select('
            tblcategory.id, 
            tblcategory.CategoryName, 
            tblcategory.Status, 
            tblcategory.CreationDate, 
            tblcategory.UpdationDate
        ');
        $this->db->from('tblcategory');
        return $this->db->get()->num_rows();
    }
}