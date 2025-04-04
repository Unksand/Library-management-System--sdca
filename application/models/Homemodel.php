<?php

class Homemodel extends CI_Model
{
    // ...p

    // public function homedata(){
    //    $this->db->select('*');
    //    $this->db->from('book_borrow as a');
    //    $query = $this->db->get();
    //    return $query->result_array();
    // }
    public function homedata($email, $password, $fullname){
        // Validate and sanitize the email and fullname variables
        $email = $this->db->escape($email);
        $fullname = $this->db->escape($fullname);

        // Select the email and password columns from the login_tbl
        $this->db->select('FullName, EmailId, Password');
        $this->db->from('tblstudents');
        $this->db->where('EmailId', $email);  // Filter by the provided email
        $this->db->where('Fullname', $fullname);  // Filter by the provided password
        
        // Execute the query
        $query = $this->db->get();
    
        // Check if a record is found
        if ($query->num_rows() == 1) {
            $result = $query->row_array();
            $storedPasswordHash = $result['Password']; // MD5 hash stored in the database
    
            // Check if the MD5 hash of the provided password matches the stored hash
            if (password_verify($password, $storedPasswordHash)) {
                return true; // Password matches
            } else {
                return false; // Password does not match
            }
        } else {
            return false; // No user found with that email
        }
    }
    
    // public function login($email, $password) {
    //     // Select the email and password columns from the login_tbl
    //     $this->db->select('email, password');
    //     $this->db->from('login_tbl');
    //     $this->db->where('email', $email);
        
    //     // Execute the query
    //     $query = $this->db->post();

    //     // Check if a user was found
    //     if ($query->num_rows() > 0) {
    //         $user = $query->row();
            
    //         // Verify the password (assuming passwords are hashed)
    //         if (password_verify($password, $user->password)) {
    //             return ['success' => true, 'message' => 'Login successful'];
    //         } else {
    //             return ['success' => false, 'message' => 'Invalid password'];
    //         }
    //     } else {
    //         return ['success' => false, 'message' => 'User  not found'];
    //     }
    // }
    // public function Login($data){
    //      // Select the email and password columns from the login_tbl
    //      $this->db->select('*');
    //      $this->db->where('email',$data['email']);
    //      $this->db->where('password',$data['password']);
    //      $this->db->from('login_tbl');
    //      $query = $this->db->get();
         
    // }
    
    
}