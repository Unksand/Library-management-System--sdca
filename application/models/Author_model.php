<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Author_model extends CI_Model {

    public function get_all_authors() {
        return $this->db->get('tblauthors')->result();
    }

    public function delete_author($id) {
        $this->db->where('id', $id)->delete('tblauthors');
    }

    public function get_authors($authorName)
    {
    $query = $this->db->query("SELECT * FROM tblauthors WHERE AuthorName LIKE ?", array('%'.$authorName.'%'));
    return $query->result();
    }

    public function get_author_by_name($authorName)
    {
    $query = $this->db->query("SELECT * FROM tblauthors WHERE AuthorName = ?", array($authorName));
    return $query->row();
    }

    public function get_author_by_id($id)
    {
    $this->db->where('id', $id);
    return $this->db->get('tblauthors')->row();
    }

    public function update_author($id, $data) {
        return $this->db->where('id', $id)->update('tblauthors', $data);
    }

    public function add_author($author_name)
    {
    $data = [
        'AuthorName' => $author_name,
        'creationDate' => date('Y-m-d H:i:s')
    ];

    $query = $this->db->query("INSERT INTO tblauthors (AuthorName, creationDate) VALUES (?, ?)", array($author_name, date('Y-m-d H:i:s')));
    return $this->db->insert_id();
    }
}