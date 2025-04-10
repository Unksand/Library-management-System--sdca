<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Login_mobile extends CI_Model {

    // Function to verify user credentials
    public function verify_login($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('users'); // Adjust the table name as per your database
    
        if ($query->num_rows() == 1) {
            $user = $query->row();
            // Compare plain-text passwords
            if ($password === $user->password) {
                return $user;
            } else {
                log_message('debug', 'Password mismatch: Input password: ' . $password . ', Stored password: ' . $user->password);
            }
        } else {
            log_message('debug', 'No user found with email: ' . $email);
        }
    
        return false;
    }
}
