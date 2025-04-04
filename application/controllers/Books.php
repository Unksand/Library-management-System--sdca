<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Book_model');
        $this->load->model('Category_model');
        $this->load->model('Author_model');
        $this->load->library('session');
        $this->load->library('Qrcode'); // Load the QR Code library
    }

    public function add() {
        // Check if the user is logged in
        if (!$this->session->userdata('alogin')) {
            redirect('login');
        }

        if ($this->input->post('add')) {
            // Retrieve form data
            $data['BookName'] = $this->input->post('bookname');
            $data['CatId'] = $this->input->post('category');
            $data['AuthorId'] = $this->input->post('author');
            $data['ISBNNumber'] = $this->input->post('isbn');
            $data['BookPrice'] = $this->input->post('price');

            // Handle file upload for book image
            $config['upload_path'] = './uploads/bookimg/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = md5(time() . $_FILES['bookpic']['name']);

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('bookpic')) {
                $this->session->set_flashdata('error', 'Invalid format. Only jpg, jpeg, png, gif formats are allowed.');
            } else {
                $data['bookImage'] = $this->upload->data('file_name');
                $insert = $this->Book_model->addBook($data);

                if ($insert) {
                    // Generate QR Code for the book
                    $qr_code_data = base_url("books/view/" . $insert); // Link to view the book
                    $qr_code_path = './uploads/qrcodes/book_' . $insert . '.png';

                    // Create QR code and save to file
                    $this->qrcode->generate($qr_code_data, $qr_code_path);

                    // Update the book record with the QR code path
                    $this->Book_model->updateBook($insert, ['QRCodeImage' => $qr_code_path]);

                    $this->session->set_flashdata('success', 'Book listed successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                }

                redirect('books/add');
            }
        }

        // Fetch categories and authors
        $data['categories'] = $this->Category_model->getAllCategories();
        $data['authors'] = $this->Author_model->getAllAuthors();

        // Load the view
        $this->load->view('Auth/add-book', $data);
    }

    public function view($book_id) {
        // Fetch book details using the book ID
        $data['book'] = $this->Book_model->getBookById($book_id);

        if (!$data['book']) {
            show_404(); // Show 404 error if the book does not exist
        }

        // Load the view with book details
        $this->load->view('Auth/view-book', $data);
    }
}
