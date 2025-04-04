<?php
defined('BASEPATH') OR exit('No direct script access allowed');





class Booksload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // // Load the Usermodel
        // $this->load->model('usermodel');
        // // // Load form validation library
        // $this->load->library('form_validation');
        // // // Load session library
        // $this->load->library('session');
        // parent::__construct();
        
    
        // Allow CORS for all origins (you can restrict to specific origins for security)
        header('Access-Control-Allow-Origin: *');  // Allows all origins
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');  // Allowed HTTP methods
        header('Access-Control-Allow-Headers: Content-Type, Authorization, Include');  // Allowed headers
        
    
    }
    public function search_books() {
        $query = $this->input->get('query');
        $is_borrowed = $this->input->get('is_borrowed'); // Capture the 'is_borrowed' parameter
    
        // Load the Bookmodel
        $this->load->model('Bookmodel');
        
        // Pass the query and is_borrowed parameter to the model
        $books = $this->Bookmodel->search_books($query, $is_borrowed);
        
        // Return the result as a JSON response
        echo json_encode($books);
    }

    public function borrow_book($book_id) {
        $user_id = 1; // Replace with actual user session data
        $this->load->model('Bookmodel');
        $result = $this->Bookmodel->borrow_book($book_id, $user_id);
        echo json_encode($result);
    }

    public function borrowed_bookss() {
        $user_id = 1; // Replace with actual user session data
        $this->load->model('Bookmodel');
        $books = $this->Bookmodel->get_borrowed_books($user_id);
        echo json_encode($books);
    }
    // Controller method to get book info by QR code
// Controller method to get book info by QR code
public function get_book_by_qrcode() {
    $this->load->model('Bookmodel');
    $qrcode = $this->input->get('qrcode');  // Capture the qr_code parameter from the URL

    if (!$qrcode) {
        echo json_encode(['error' => 'QR code is required']);
        return;
    }

    // Query the database for the book matching the QR code
    
    $book = $this->Bookmodel->get_book_by_qrcode($qrcode);

    if ($book) {
        echo json_encode($book);  // Return the book data if found
    } else {
        echo json_encode(['message' => 'No book found for the given QR code']);
    }
}



   
}
