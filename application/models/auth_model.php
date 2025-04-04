<?php
class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login_user($email, $password)
    {
        $query = $this->db->query("SELECT * FROM users WHERE email = ?", array($email));

        if ($query->num_rows() == 1) {
            $user = $query->row();

            // Check the plain password (replace this with password_verify for hashed passwords)
            if ($password === $user->password) {
                return $user; // Return user data if login is successful
            }
        }

        return false; // Login failed
    }
}