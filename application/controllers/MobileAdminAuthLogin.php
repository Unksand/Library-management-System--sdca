<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MobileAdminAuthLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        header('Access-Control-Allow-Origin: *');  // Allows all origins
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');  // Allowed HTTP methods
        header('Access-Control-Allow-Headers: Content-Type, Authorization, Include');  // Allowed headers
        // Load the model
        // $this->load->database();
        $this->load->helper('url');
        $this->load->library('Session');
        $this->load->model('Admin_Login_mobile'); // Adjust the model name as per your file
    }

    // Function to handle AJAX login
    public function ajax_login() {
        // Get the POST data
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Call the model function to verify login
        $user = $this->Admin_Login_mobile->verify_login( $email, $password);

        if  (empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Email Is wrong']);
            return;
        }
        // Check if user credentials are correct
        if ($user) {
            // Return success response if login is valid
            echo json_encode(['status' => 'success', 'message' => 'Login successful']);
        } else {
            // Return error response if credentials are invalid
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
        }
    }
    public function check_logged_in() {
        if ($this->session->userdata('logged_in')) {
            echo json_encode(['success' => true, 'message' => 'User is logged in.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
        }
    }
    public function logout() {
        $this->session->sess_destroy();
        echo json_encode(['success' => true, 'message' => 'Logged out successfully.']);
    }
    
}
