<?php
require_once BASEPATH . '../vendor/autoload.php';
use Endroid\QrCode\QrCode;

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary models and helpers
        $this->load->model('auth_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Analytics_model');
        $this->load->model('Book_model');
        $this->load->model('Category_model');
        $this->load->model('Author_model');
        $this->load->model('Staff_model'); // Model to handle staff operations
        $this->load->model('Student_model'); // Load the Student model
        $this->load->model('Program_model'); // Make sure the model is loaded
        $this->load->model('Issuedbooks_model');
        $this->load->library('session'); // To manage session data
        $this->load->helper(['url', 'form']); // URL and form helpers

        $this->load->database(); // Load the database connection
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('Auth/login'); // Redirect to login only if not logged in
        }

        // Fetch data from the Dashboard_model
        $data['books_count'] = $this->Dashboard_model->get_books_count();
        $data['not_returned_count'] = $this->Dashboard_model->get_not_returned_count();
        $data['staff_count'] = $this->Dashboard_model->get_staff_count();
        $data['author_count'] = $this->Dashboard_model->get_author_count();
        $data['category_count'] = $this->Dashboard_model->get_category_count();

        // Fetch the count of school programs
        $program_count = $this->Program_model->get_all_programs();
        $data['program_count'] = count($program_count);

        // Load the index view for logged-in users
        $this->load->view('Auth/index', $data);
    }

    public function login()
    {
        // Check if the user is already logged in
        if ($this->session->userdata('logged_in')) {
            redirect('Auth');
        }

        $this->load->view('Auth/login');
    }

    public function logout() {
        // Destroy session
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('email');
        $this->session->sess_destroy();

        // Redirect to login page
        $this->session->set_flashdata('suc', 'Logged out successfully.');
        redirect('Auth/login');
    }

    public function main()
    {
        // Ensure only logged-in users can access
        if (!$this->session->userdata('logged_in')) {
            redirect('Auth/index');
        }

        // Fetch any necessary data for the dashboard
        $data['user'] = $this->session->userdata('user');

        // Load the main dashboard view
        $this->load->view('Auth/index', $data);
    }

    // Handle login submissions
    public function login_form() {
        // Get input from form
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        
        // Load the Auth_model
        $this->load->model('Auth_model');
        
        // Check if the user exists and the credentials are valid
        $user = $this->Auth_model->login_user($email, $password);
        
        if ($user) {
            // Set session data for the logged-in user
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('email', $user->email);
            $this->session->set_userdata('user', $user);
        
            // Redirect to the dashboard
            $this->session->set_flashdata('suc', 'Login successful!');
            redirect('Auth');
        } else {
            // Invalid email or password
            $this->session->set_flashdata('worng', 'Invalid email or password.');
            redirect('Auth/login');
        }
    }

    public function analytics()
    {
    $data['books_count'] = $this->Analytics_model->get_books_count();
    $data['not_returned_count'] = $this->Analytics_model->get_not_returned_count();
    $data['staff_count'] = $this->Dashboard_model->get_staff_count();
    $data['author_count'] = $this->Analytics_model->get_author_count();
    $data['category_count'] = $this->Analytics_model->get_category_count();

    $this->load->view('Auth/analytics', $data);
    }

    public function manage_books()
    {
        $this->load->model('Book_model');
        // Set the limit and offset for pagination
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Fetch books data
        $total_books = $this->Book_model->count_all_books();
        $total_pages = ceil($total_books / $limit);
        $books = $this->Book_model->get_books_paginated($limit, $offset);
        $data['books'] = $books;
        $data['total_books'] = $total_books;
        $data['total_pages'] = $total_pages;
        $data['page'] = $page;
        $data['limit'] = $limit;

        // Get the sorting order
        $sort_order = isset($_GET['sort_order']) ? $this->input->get('sort_order', true) : 'asc';
        $sort_by = isset($_GET['sort_by']) ? $this->input->get('sort_by', true) : 'none';

        // Validate sort_by and sort_order
        if (!in_array($sort_by, ['id', 'BookName', 'ISBNNumber', 'ContentType', 'Publisher', 'AuthorId', 'ProgramID', 'BookEdition', 'BookLanguage', 'TotalPages', 'YearPublished', 'PlaceOfPublication', 'NumberOfCopies'])) {
            $sort_by = 'id';
        }
        if (!in_array($sort_order, ['asc', 'desc'])) {
            $sort_order = 'asc';
        }

        // Fetch books data based on the sorting order
        if ($sort_by == 'none') {
            $books = $this->Book_model->get_books_paginated($limit, $offset);
        } else {
            $books = $this->Book_model->get_books_paginated($limit, $offset, $sort_by, $sort_order);
        }

        // Pagination links
        $pagination_links = '';
        if ($page > 1) {
            $pagination_links .= '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '">Previous</a></li>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            $pagination_links .= '<li class="page-item ' . (($i == $page) ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '">' . $i . '</a></li>';
        }

        if ($page < $total_pages) {
            $pagination_links .= '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&sort_by=' . $sort_by . '&sort_order=' . $sort_order . '">Next</a></li>';
        }

        $data['pagination_links'] = $pagination_links;

        $data['books'] = $books;
        $data['total_books'] = $total_books;
        $data['total_pages'] = $total_pages;
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $this->load->view('Auth/manage-books', $data);
        $this->Book_model->update_old_books();
    }

    public function add_book() {
        $this->load->model('Book_model');
         //$this->load->model('Category_model');
        $this->load->model('Author_model');
        $this->load->model('Program_model'); // Load the Program_model
    
        // Fetch authors and programs for the dropdown
        $data['authors'] = $this->Author_model->get_all_authors();
         //$data['categories'] = $this->Category_model->get_all_categories();
        $data['programs'] = $this->Program_model->get_all_programs();
    
        if ($this->input->post()) {
            $bookData = [
                'BookName' => $this->input->post('bookname', true),
                'AuthorId' => $this->input->post('author', true),
                //'CatId' => $this->input->post('category'),
                'Publisher' => $this->input->post('publisher', true),
                'ISBNNumber' => $this->input->post('isbn', true),
                'ContentType' => $this->input->post('contenttype', true),
                'ProgramID' => $this->input->post('program', true),
                'BookEdition' => $this->input->post('bookedition', true),
                'BookLanguage' => $this->input->post('booklanguage', true),
                'TotalPages' => (int)$this->input->post('totalpages'),
                'YearPublished' => (int)$this->input->post('yearpublished'),
                'PlaceOfPublication' => $this->input->post('placeofpublication', true),
                'NumberOfCopies' => (int)$this->input->post('numberofcopies'),
            ];
    
            // Upload image
            if ($_FILES['bookpic']['name'] != '') {
                $config['upload_path'] = './assets/bookimg/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 2048;
                $config['remove_space'] = TRUE;
    
                $this->load->library('upload', $config);
    
                if (!$this->upload->do_upload('bookpic')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', 'Failed to upload image.');
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $bookImage = $data['upload_data']['file_name'];
                    $bookData['bookImage'] = $bookImage;
                }
            }
    
            // Handle QR code generation
            $qrCodeData = $this->input->post('qrcode_data', true);
            if (!empty($qrCodeData)) {
                $this->load->library('ciqrcode'); // Load the Ciqrcode library
    
                // Define the file name and path for the QR Code
                $qrCodeFileName = time() . '_qr.png';
                $qrCodePath = './uploads/' . $qrCodeFileName;
    
                $params = [
                    'data' => $qrCodeData,
                    'level' => 'H', // Error correction level
                    'size' => 10,   // QR code size
                    'savename' => $qrCodePath, // Save QR code to this path
                ];
    
                try {
                    $this->ciqrcode->generate($params); // Generate the QR code
                    $bookData['QRCodeImage'] = $qrCodeFileName; // Save the filename in the database
                } catch (Exception $e) {
                    $this->session->set_flashdata('error', 'Failed to generate QR Code: ' . $e->getMessage());
                    redirect('auth/add_book');
                }
            }

            $data = array(
                'BookName' => 'Example Book',
                'QRCodeImage' => 'example_qr_code_image.png',
                // Other book data...
            );
            
            $book_id = $this->Book_model->insert_book($data);
    
            // Insert the book data into the database
            if ($this->Book_model->insert_book($bookData)) {
                // Hash the QR code image information
                $hashed_qr_code_image_text = hash('sha256', $qrCodeData);
                
                // Update the book data with the hashed QR code image information
                $update_data = [
                    'HashedQRCodeImageText' => $hashed_qr_code_image_text
                ];
                $this->Book_model->update_book($this->Book_model->insert_id(), $update_data);
                
                $this->session->set_flashdata('success', 'Book added successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to add the book.');
            }
            
            redirect('auth/add_book');
        }
    
        $this->load->view('Auth/add-book', $data);
    }

    // Edit book details
    public function edit_book($id) {
        $this->load->model(['Book_model', 'Author_model', 'Program_model']); //'Category_model'
        $this->load->library(['form_validation']);
        
        $this->form_validation->set_rules('bookname', 'Book Name', 'required');
        //$this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('author', 'Author', 'required|callback_validate_author');
        $this->form_validation->set_rules('program', 'Program', 'required');
        $this->form_validation->set_rules('isbn', 'ISBN', 'required');
        $this->form_validation->set_rules('content-type', 'Content Type', 'required');
        $this->form_validation->set_rules('publisher', 'Publisher', 'required');
        $this->form_validation->set_rules('bookedition', 'Book Edition', 'required');
        $this->form_validation->set_rules('booklanguage', 'Book Language', 'required');
        $this->form_validation->set_rules('totalpages', 'Total Pages', 'required|numeric');
        $this->form_validation->set_rules('yearpublished', 'Year Published', 'required|numeric');
        $this->form_validation->set_rules('placeofpublication', 'Place of Publication', 'required');
        
        if ($this->form_validation->run() == TRUE) {
            // Upload image
            if ($_FILES['bookImage']['name'] != '') {
                $config['upload_path'] = './assets/bookimg/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 2048;
                $config['remove_space'] = TRUE;
        
                $this->load->library('upload', $config);
        
                if (!$this->upload->do_upload('bookImage')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', 'Failed to upload image.');
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $bookImage = $data['upload_data']['file_name'];
                }
            } else {
                $bookImage = $this->input->post('old_book_image', true);
            }
        
            // Update book data
            $data = [
                'BookName' => $this->input->post('bookname', true),
                'ISBNNumber' => $this->input->post('isbn', true),
                'ContentType' => $this->input->post('content-type', true),
                'Publisher' => $this->input->post('publisher', true),
                //'CatId' => $this->input->post('category'),
                'ProgramID' => $this->input->post('program', true),
                'UpdationDate' => date('Y-m-d H:i:s'),
                'bookImage' => $bookImage,
                'BookEdition' => $this->input->post('bookedition', true),
                'BookLanguage' => $this->input->post('booklanguage', true),
                'TotalPages' => (int)$this->input->post('totalpages'),
                'YearPublished' => (int)$this->input->post('yearpublished'),
                'PlaceOfPublication' => $this->input->post('placeofpublication', true),
                'NumberOfCopies' => (int)$this->input->post('numberofcopies'),
            ];
        
            $authorName = $this->input->post('author', true);
            $author = $this->Author_model->get_author_by_name($authorName);
            if ($author) {
                $data['AuthorId'] = $author->id;
            } else {
                // If the author does not exist, add it to the database
                $authorId = $this->Author_model->add_author($authorName);
                $data['AuthorId'] = $authorId;
            }

            $hashed_qr_code_image_text = hash('sha256', $qrCodeData);
            $data['HashedQRCodeImageText'] = $hashed_qr_code_image_text;
        
            if ($this->Book_model->update_book($id, $data)) {
                $this->session->set_flashdata('msg', 'Book updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update the book.');
            }
        
            // Redirect to manage-books page
            redirect('Auth/manage_books');
        }
        
        // Load view with data
        $data = [
            'book' => $this->Book_model->get_book_by_id($id),
            //'categories' => $this->Category_model->get_all_categories(),
            'authors' => $this->Author_model->get_all_authors(),
            'programs' => $this->Program_model->get_all_programs(),
        ];
        $this->load->view('Auth/edit-book', $data);
    }

    public function delete_book($id)
    {
    $this->load->model('Book_model');
    $this->Book_model->delete_book($id);
    $this->session->set_flashdata('msg', 'Book deleted successfully.');
    redirect('Auth/manage_books');
    }

    public function issue_book()
    {
    $this->load->model('Issuedbooks_model');
    $this->load->model('Book_model');

    if ($this->input->post('issue')) {
        $student_id = strtoupper($this->input->post('studentid', true));
        $book_id = $this->input->post('bookid', true);
        $is_issued = 1;

        $result = $this->Issuedbooks_model->issue_book($student_id, $book_id, $is_issued);

        if ($result) {
            $this->session->set_flashdata('msg', 'Book issued successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
        }
        redirect('Auth/manage_issued_books');
    } else {
        $this->load->view('Auth/issue-book');
    }
    }

    public function update_issue_bookdeails($rid)
    {
    // Load the correct model
    $this->load->model('Issuedbooks_model');

    // Fetch book details by 'rid'
    $book_details = $this->Issuedbooks_model->get_issued_book_details($rid);

    // Check if details exist
    if (!$book_details) {
        show_404(); // Show a 404 error if no data found
    }

    // Pass the data to the view
    $data['book_details'] = $book_details;
    $this->load->view('Auth/update-issue-bookdeails', $data);
    }
    
    public function generate_qr_code() {
        $qr_data = $this->input->post('qr_data', true);
        $qr_code_path = $this->input->post('qr_code_path', true);
    
        $qr_code = json_decode($qr_data, true);
    
        $authorName = '';
        $programName = '';
    
        //foreach ($this->Category_model->get_all_categories() as $category) {
            //if ($category->id == $qr_code['CategoryID']) {
                //$categoryName = $category->CategoryName;
                //break;
           // }
        //}
    
        foreach ($this->Author_model->get_all_authors() as $author) {
            if ($author->id == $qr_code['AuthorID']) {
                $authorName = $author->AuthorName;
                break;
            }
        }
    
        foreach ($this->Program_model->get_all_programs() as $program) {
            if ($program->id == $qr_code['ProgramID']) {
                $programName = $program->SchoolCourse;
                break;
            }
        }
    
        $qr_text = 'Book ID: ' . $qr_code['BookID'] . "\n";
        $qr_text .= 'Book Name: ' . $qr_code['BookName'] . "\n";
        $qr_text .= 'ISBN: ' . $qr_code['ISBN'] . "\n";
        $qr_text .= 'Content Type: ' . $qr_code['ContentType'] . "\n";
        $qr_text .= 'Publisher: ' . $qr_code['Publisher'] . "\n";
        //$qr_text .= 'Category: ' . $categoryName . "\n";
        $qr_text .= 'Author: ' . $authorName . "\n";
        $qr_text .= 'Program: ' . $programName . "\n";
        $qr_text .= 'Book Edition: ' . $qr_code['BookEdition'] . "\n";
        $qr_text .= 'Book Language: ' . $qr_code['BookLanguage'] . "\n";
        $qr_text .= 'Total Pages: ' . $qr_code['TotalPages'] . "\n";
        $qr_text .= 'Year Published: ' . $qr_code['YearPublished'] . "\n";
        $qr_text .= 'Place of Publication: ' . $qr_code['PlaceOfPublication'];

        $hashed_qr_code_image_text = hash('sha256', $qr_text);
    
        // Update the book data with the hashed QR code image information
        $update_data = [
            'HashedQRCodeImageText' => $hashed_qr_code_image_text
        ];
        $this->Book_model->update_book($book_id, $update_data);
    
        $qrCode = (new Endroid\QrCode\QrCodeBuilder())
            ->setText($qr_text)
            ->setSize(200)
            ->setPadding(10)
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
            ->setWriterByName('png')
            ->writeString();
    
        file_put_contents($qr_code_path, $qrCode);
    
        echo json_encode(['success' => true]);
    }
    
    public function delete_qr_code() {
        $qr_code_path = $this->input->post('qr_code_path', true);
        $hashed_qr_code_data = $this->input->post('hashed_qr_code_data', true);
        $book_id = $this->input->post('book_id', true);
    
        if (file_exists(FCPATH . $qr_code_path)) {
            if (unlink(FCPATH . $qr_code_path)) {
                $response = array('success' => true, 'message' => 'QR code deleted successfully.');
            } else {
                $response = array('success' => false, 'error' => 'Failed to delete QR code.');
            }
        } else {
            $response = array('success' => false, 'error' => 'QR code file not found.');
        }
    
        $update_data = [
            'HashedQRCodeImageText' => '',
            'QRCodeImage' => ''
        ];
        $this->Book_model->update_book($book_id, $update_data);
    
        echo json_encode($response);
    }

    public function add_category()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // Collect form data
            $category_name = $this->input->post('category', true);
            $status = $this->input->post('status', true);

            // Validate form input
            if (!empty($category_name) && in_array($status, ['0', '1'])) {
                $data = [
                    'CategoryName' => $category_name,
                    'Status' => $status
                ];

                // Add category to the database
                if ($this->Category_model->add_category($data)) {
                    $this->session->set_flashdata('msg', 'Category added successfully.');
                    echo "<script>
                        swal({
                            title: 'Course Added!',
                            text: 'Course added successfully!',
                            type: 'success'
                        });
                    </script>";
                } else {
                    $this->session->set_flashdata('error', 'Failed to add category. Please try again.');
                    echo "<script>
                        swal({
                            title: 'Error!',
                            text: 'Error adding course!',
                            type: 'error'
                        });
                    </script>";
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid input. Please fill in the form correctly.');
                echo "<script>
                    swal({
                        title: 'Invalid Input!',
                        text: 'Invalid input!',
                        type: 'error'
                    });
                </script>";
            }

            redirect('Auth/manage_categories');
        } else {
            $this->load->view('auth/add-category');
        }
    }

    public function edit_category($id)
    {
        // Check if the form is submitted
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $category_name = $this->input->post('category_name', true);
            $status = $this->input->post('status', true);

            // Load the Category_model
            $this->load->model('Category_model');
            $data = [
                'CategoryName' => $category_name,
                'Status' => $status
            ];

            // Update category in the database
            if ($this->Category_model->update_category($id, $data)) {
                $this->session->set_flashdata('msg', 'Category updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update category. Please try again.');
            }
            redirect('Auth/manage_categories');
        } else {
            // Load the category data
            $this->load->model('Category_model');
            $data['category'] = $this->Category_model->get_category_by_id($id);

            // Load the edit view with category data
            $this->load->view('Auth/edit-category', $data);
        }
    }

    public function manage_categories()
    {
        $this->load->model('Category_model'); // Load the category model

        // Set the limit and offset for pagination
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Fetch categories
        $total_categories = $this->Category_model->count_all_categories();
        $total_pages = ceil($total_categories / $limit);
        $categories = $this->Category_model->get_all_categories($limit, $offset);
        $data['categories'] = $categories;
        $data['total_categories'] = $total_categories;
        $data['total_pages'] = $total_pages;
        $data['page'] = $page;
        $data['limit'] = $limit;

        // Retrieve deletion message if any
        $data['delmsg'] = $this->session->flashdata('delmsg');

        $this->load->view('Auth/manage-categories', $data); // Load the view
    }

    public function delete_category($id)
    {
        $this->load->model('Category_model');
        $this->Category_model->delete_category($id); // Call model to delete category
        $this->session->set_flashdata('delmsg', 'Category deleted successfully.');
        redirect('Auth/manage_categories'); // Redirect to manage categories page
    }

    public function update_category($id, $data)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('tblcategory', $data);

        // Debug logging
        log_message('info', 'Update Query: ' . $this->db->last_query());

        return $result; // True on success, false on failure
    }

    public function manage_issued_books()
    {
    // Load the Issuedbooks_model
    $this->load->model('Issuedbooks_model');

    // Set the limit and offset for pagination
    $limit = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Validate the page variable
    if (!is_numeric($page) || $page < 1) {
        $page = 1;
    }

    // Fetch issued books data
    $issued_books = $this->Issuedbooks_model->get_all_issued_books($limit, $offset);
    $data['issued_books'] = $issued_books;

    // Count the total number of issued books
    $total_books = count($this->Issuedbooks_model->get_all_issued_books());
    $data['total_books'] = $total_books;

    // Calculate the total number of pages
    $total_pages = ceil($total_books / $limit);
    $data['total_pages'] = $total_pages;

    // Fetch issued books data
    $issued_books = $this->Issuedbooks_model->get_all_issued_books();
    $data['issued_books'] = $issued_books;

    // Count the books that are not returned
    $data['not_returned_count'] = count($issued_books);

    // Pass the page variable to the view
    $data['page'] = $page;

    // Load the view with the data
    $this->load->view('Auth/manage-issued-books', $data);
    }

    public function add_author()
{
    // Check if the form is submitted
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $author_name = $this->input->post('author_name', true);

        // Load the Author_model
        $this->load->model('Author_model');
        $insert_id = $this->Author_model->add_author($author_name);

        // Check if the author was added successfully
        if ($insert_id) {
            $this->session->set_flashdata('msg', 'Author Listed successfully');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
        }
        redirect('Auth/manage_authors');
    } else {
        $this->load->view('Auth/add-author'); // Load the add-author view
    }
}

public function edit_author($id) {
    $this->load->model('Author_model');
    
    // Fetch the author data
    $author = $this->Author_model->get_author_by_id($id);
    if (!$author) {
        $this->session->set_flashdata('error', 'Author not found.');
        redirect('Auth/manage_authors');
        return;
    }
        
    // Handle form submission
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $author_name = $this->input->post('author_name', true); // Sanitize input
            
        if (empty($author_name)) {
            $this->session->set_flashdata('error', 'Author name cannot be empty.');
            redirect('auth/edit_author/' . $id);
            return;
        }
            
        $data = [
            'AuthorName' => $author_name,
            'UpdationDate' => date('Y-m-d H:i:s') // Update timestamp
        ];
            
        if ($this->Author_model->update_author($id, $data)) {
            $this->session->set_flashdata('msg', 'Author updated successfully.');
            redirect('Auth/manage_authors');
        } else {
            $this->session->set_flashdata('error', 'Failed to update the author. Please try again.');
            redirect('auth/edit_author/' . $id);
     }
        }
        
        // Load the edit view with author data
        $data['author'] = $author;
        $this->load->view('auth/edit-author', $data);
    }

    public function update_author($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tblauthors', $data);
        return $this->db->affected_rows();
    }

    public function manage_authors()
    {
    $this->load->model('Author_model'); // Load the author model
    $data['authors'] = $this->Author_model->get_all_authors(); // Fetch authors
    $data['delmsg'] = $this->session->flashdata('delmsg'); // Retrieve deletion message if any

    $this->load->view('Auth/manage-authors', $data); // Load the view
    }

    public function get_authors()
    {
    $authorName = $this->input->post('author_name', true);
    $this->load->model('Author_model');
    $authors = $this->Author_model->get_authors($authorName);
    echo json_encode($authors);
    }

    public function delete_author($id)
    {
        $this->load->model('Author_model');
        $this->Author_model->delete_author($id); // Call model to delete author
        $this->session->set_flashdata('delmsg', 'Author deleted successfully.');
        redirect('Auth/manage_authors'); // Redirect to manage authors page
    }

    public function validate_author($authorName)
    {
        $this->load->model('Author_model');
        $author = $this->Author_model->get_author_by_name($authorName);
        if (!$author) {
            $this->form ->set_message('validate_author', 'Author not found. Please add the author first.');
            return false;
        }
        return true;
    }

    public function reg_students()
    {
        // Load the Student_model
        $this->load->model('Student_model');

        // Set the limit and offset for pagination
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Validate the page variable
        if (!is_numeric($page) || $page < 1) {
            $page = 1;
        }

        // Fetch students data
        $student = $this->Student_model->get_all_students($limit, $offset);
        $data['student'] = $student;

        // Count the total number of students
        $total_students = $this->Student_model->count_all_students();
        $data['total_students'] = $total_students;

        // Calculate the total number of pages
        $total_pages = ceil($total_students / $limit);
        $data['total_pages'] = $total_pages;

        // Pass the page variable to the view
        $data['page'] = $page;

        // Load the view and pass staff data
        $this->load->view('auth/reg-students', $data);
    }

    public function reg_staff()
    {
        // Load the Staff_model
        $this->load->model('Staff_model');

        // Set the limit and offset for pagination
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Validate the page variable
        if (!is_numeric($page) || $page < 1) {
            $page = 1;
        }

        // Fetch staff data
        $staff = $this->Staff_model->get_all_staff($limit, $offset);
        $data['staff'] = $staff;

        // Count the total number of staff
        $total_staff = $this->Staff_model->get_staff_count();
        $data['total_staff'] = $total_staff;

        // Calculate the total number of pages
        $total_pages = ceil($total_staff / $limit);
        $data['total_pages'] = $total_pages;

        // Pass the page variable to the view
        $data['page'] = $page;

        // Load the view with the data
        $this->load->view('auth/reg-staff', $data);

        // Load the view and pass staff data
        $this->load->view('auth/reg-staff', $data);
    }

    public function staff_details($sid) {
        $data['staff'] = $this->Staff_model->get_staff_details($sid);
        $this->load->view('auth/staff_details', $data);
    }

    public function toggle_staff_status($id, $status)
    {
        // Validate the id and status variables
        if (!is_numeric($id) || !is_numeric($status)) {
            $this->session->set_flashdata('error', 'Invalid input. Please try again.');
            redirect('Auth/reg_students');
        }

        // Update staff status (1 = Active, 0 = Inactive)
        $update_status = $this->Staff_model->update_staff_status($id, $status);

        if ($update_status) {
            $this->session->set_flashdata('msg', 'Staff status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update staff status.');
        }

        redirect('Auth/reg_students');
    }

    public function add_program()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            // Collect form data
            $school_course = $this->input->post('course', true);
            $status = $this->input->post('status', true);

            // Validate form input
            if (!empty($school_course) && in_array($status, ['Active', 'Inactive'])) {
                $data = [
                    'SchoolCourse' => $school_course,
                    'Status' => $status
                ];

                // Add program to the database
                if ($this->Program_model->add_program($data)) {
                    $this->session->set_flashdata('msg', 'Program added successfully.');
                    echo "<script>
                        swal({
                            title: 'Program Added!',
                            text: 'Program added successfully!',
                            type: 'success'
                        });
                    </script>";
                    redirect('Auth/school_programs');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add program. Please try again.');
                    echo "<script>
                        swal({
                            title: 'Error!',
                            text: 'Error adding program!',
                            type: 'error'
                        });
                    </script>";
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid input. Please fill in the form correctly.');
                echo "<script>
                    swal({
                        title: 'Invalid Input!',
                        text: 'Invalid input!',
                        type: 'error'
                    });
                </script>";
            }
        } else {
            $this->load->view('auth/add-program');
        }
    }

    public function edit_program($id)
    {
        $this->load->model('Program_model');
        $program = $this->Program_model->get_program_by_id($id);

        if (!$program) {
            $this->session->set_flashdata('error', 'Program not found.');
            redirect('Auth/manage_programs');
        }

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $school_course = $this->input->post('course', true);
            $status = $this->input->post('status', true);

            // Validate form input
            if (!empty($school_course) && in_array($status, ['Active', 'Inactive'])) {
                $data = [
                    'SchoolCourse' => $school_course,
                    'Status' => $status
                ];

                // Update program in the database
                if ($this->Program_model->update_program($id, $data)) {
                    $this->session->set_flashdata('msg', 'Program updated successfully.');
                    redirect('Auth/school_programs');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update program. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid input. Please fill in the form correctly.');
            }
        } else {
            $data['program'] = $program;
            $this->load->view('auth/edit-program', $data);
        }
    }

    public function delete_program($id)
    {
        $this->load->model('Program_model');
        if ($this->Program_model->delete_program($id)) {
            $this->session->set_flashdata('msg', 'Program deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete program.');
        }
        redirect('Auth/school_programs');
    }

    public function school_programs()
    {
        $this->load->model('Program_model');

        // Set the limit and offset for pagination
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Validate the page variable
        if (!is_numeric($page) || $page < 1) {
            $page = 1;
        }

        // Fetch programs data
        $total_programs = $this->Program_model->count_all_programs ();
        $total_pages = ceil($total_programs / $limit);
        $programs = $this->Program_model->get_all_programs($limit, $offset);
        $data['programs'] = $programs;
        $data['total_programs'] = $total_programs;
        $data['total_pages'] = $total_pages;
        $data['page'] = $page;
        $data['limit'] = $limit;

        $this->load->view('auth/school-programs', $data);
    }

    public function update_issue_bookdetails($rid)
    {
        // Check for form submission
        if ($this->input->post('return')) {
            $fine = $this->input->post('fine');
            $bookid = $this->input->post('bookid');
            $rstatus = 1;

            // Update issued book details
            $update_status = $this->Issuedbooks_model->return_book($rid, $fine, $rstatus, $bookid);

            if ($update_status) {
                $this->session->set_flashdata('msg', 'Book Returned successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to return the book. Please try again.');
            }
            redirect('Auth/manage_issued_books');
        }

        // Fetch issued book details
        $data['book_details'] = $this->Issuedbooks_model->get_issued_book_details($rid);

        // Load the view with data
        $this->load->view('auth/update-issue-bookdetails', $data);
    }

    public function block_student($id)
    {
        $status = 0;
        $this->Student_model->update_student_status($id, $status);
        redirect('auth/registered_students'); // Redirect after update
    }

    // Activate student
    public function activate_student($id)
    {
        $status = 1;
        $this->Student_model->update_student_status($id, $status);
        redirect('auth/registered_students'); // Redirect after update
    }

    // View student history
    public function student_history($sid)
    {
    if (!$this->session->userdata('alogin')) {
        redirect('auth/index'); // Redirect to login if not logged in
    }

    if (empty($sid)) {
        $this->session->set_flashdata('error', 'Student ID is required.');
        redirect('auth/reg_students');
    }

    $data['student_history'] = $this->Student_model->get_student_history($sid);
    $data['sid'] = $sid;

    // Load the student history view
    $this->load->view('includes/header');
    $this->load->view('Auth/student-history', $data);
    $this->load->view('includes/footer');
    }

    public function register()
    {
        $this->load->view('Auth/register');
    }

    public function registration_form()
    {
        $this->auth_model->register_user();
    }

}
