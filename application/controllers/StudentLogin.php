<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentLogin extends CI_Controller {

    // public function __construct() {
    //     parent::__construct();
    //     $this->load->model('usermodel'); // Load your user model
    // }

    // public function login() {
    //     // Check database connection
    //     if ($this->db->conn_id) {
    //         // Load the login view if the database connection is successful
    //         $this->load->view('login_form');
    //     } else {
    //         // Handle the error if the database connection fails
    //         echo "Database connection failed!";
    //         // You can also redirect to an error page or log the error
    //     }

    // }

    // public function authenticate() {
    //     $email = $this->input->post('email');
    //     $password = $this->input->post('password');

    //     // Check if the user exists in the database
    //     $user = $this->usermodel->get_user($email, $password);

    //     if ($user) {
    //         // Set session data if login is successful
    //         $this->session->set_userdata('user_id', $user->id);
    //         redirect('dashboard'); // Redirect to dashboard
    //     } else {
    //         // Set an error message
    //         $this->session->set_flashdata('error', 'Invalid email or password');
    //         redirect('auth/login'); // Redirect back to login
    //     }
    // }
    public function __construct() {
        parent::__construct();
        // // Load the Usermodel
        // $this->load->model('usermodel');
        // // // Load form validation library
        // $this->load->library('form_validation');
        // // // Load session library
        // $this->load->library('session');
        // parent::__construct();
        $this->load->model('usermodel'); // Load the Usermodel
        $this->load->helper('url');
        $this->load->library('Session');

		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Method: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Request-Header: Content-Type,Accept, Authorization');
		header('Access-Control-Allow-Credentials: true'); // Allow cookies
        
	
    }

    public function index() {
        
        // $this->load->view('login_form'); // Load the login view
        // Get POST data
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        

        // Validate inputs
        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
            return;
        }

        // Attempt to login
        $user = $this->usermodel->login($email, $password);

        if ($user) {
            echo json_encode(['success' => true, 'message' => 'Login successful.', 'data' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid Email or password.']);
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
    

    // Method to handle user login
    // public function login() {
    //     // Set validation rules
    //     $this->form_validation->set_rules('studentNumber', 'Student Number', 'required');
    //     $this->form_validation->set_rules('password', 'Password', 'required');

    //     if ($this->form_validation->run() == FALSE) {
    //         // Validation failed
    //         echo json_encode(['success' => false, 'message' => validation_errors()]);
    //         return;
    //     }

    //     // Get input data
    //     $studentNumber = $this->input->post('studentNumber');
    //     $password = $this->input->post('password');

    //     // Check user credentials
    //     $user = $this->usermodel->validate_user($studentNumber, $password);

    //     if ($user) {
    //         // Successful login
    //         $this->session->set_userdata('user_id', $user->id); // Store user ID in session
    //         echo json_encode(['success' => true, 'redirect' => base_url('dashboard')]); // Redirect to dashboard
    //     } else {
    //         // Invalid credentials
    //         echo json_encode(['success' => false, 'message' => 'Invalid student number or password.']);
    //     }
    // }

    // // Method to handle user logout
    // public function logout() {
    //     $this->session->sess_destroy(); // Destroy the session
    //     redirect('home'); // Redirect to the home page
    // }
}