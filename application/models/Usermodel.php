<?php
class Usermodel extends CI_Model {

    // public function getuser($email, $password) {
    //     // Select email and password from login_tbl
    //     $this->db->select('email, password');
    //     $this->db->from('login_tbl');
    //     $this->db->where('email', $email);
    //     $this->db->where('password', md5($password)); // Make sure to hash the password

    //     $query = $this->db->get(); // Execute the query

    //     if ($query->num_rows() == 1) {
    //         return $query->row(); // Return user data
    //     } else {
    //         return false; // User not found
    //     }
    // }


    public function __construct() {
        parent::__construct();
        
        $this->load->database();

        
    }

    // public function validate_user($studentNumber, $password) {
    //     // Query to check if the user exists
    //     $this->db->where('email', $studentNumber);
    //     $query = $this->db->get('login_tbl');

    //     if ($query->num_rows() == 1) {
    //         $user = $query->row();
    //         // Compare the plain text password
    //         if ($user->password === $password) {
    //             return $user; // Return user data if successful
    //         }
    //     }

    //     return false; // Invalid credentials
    // }

    // WITH PASSWORD HASHING

    
    // public function login($email, $password) {
    //     // Assuming you have a users table with fields 'student_number' and 'password'
    //     $this->db->where('email', $email);
    //     $this->db->where('password', md5($password)); // Use appropriate hashing
    //     $query = $this->db->get('login_tbl');

    //     if ($query->num_rows() == 1) {
    //         return $query->row(); // Return user data
    //     } else {
    //         return false; // No user found
    //     }
    // }


    public function login($email, $password) {
        // Hash the input password using MD5 before comparing
        $hashedPassword = md5($password);
    
        // Assuming you have a users table with fields 'email' and 'password'
        $this->db->where('EmailId', $email);
        $this->db->where('Password', $hashedPassword); // Compare the hashed password
        $query = $this->db->get('tblstudents');
    
        if ($query->num_rows() == 1) {
            return $query->row(); // Return user data
        } else {
            return false; // No user found
        }
    }
    
}

?>