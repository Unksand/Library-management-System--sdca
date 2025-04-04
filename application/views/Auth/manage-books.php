<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Manage Books</title>
    <link href="<?php echo site_url(); ?>assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo site_url(); ?>assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo site_url(); ?>assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="<?php echo site_url(); ?>assets/css/style.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .qr-code-preview {
            max-width: 100px;
            max-height: 100px;
            width: auto;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin: 0 auto;
            display: block;
        }

        .header-line {
            font-size: 24px;
            font-weight: bold;
            color:rgb(64, 52, 52);
            text-align: center;
            margin-bottom: 20px;
        }

        .panel {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgb(237, 91, 91);
        }

        .panel-heading {
            background-color: rgb(244, 98, 88) !important;
            color: #fff !important;
            font-size: 18px;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .btn {
            border-radius: 20px;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .table thead th {
            background-color: rgb(251, 109, 109);
            color: #fff;
        }

        .table th, .table td {
            text-align: center;
        }
        
        .table tbody tr:hover {
            background-color: #f75959;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #2baaef;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2fe3ff;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .pagination .page-link {
            color: red !important;
            border-color: red !important;
        }

        .pagination .page-item.active .page-link {
            background-color: red !important;
            border-color: red !important;
            color: white !important;
        }

        .pagination .page-link:hover {
            background-color: red !important;
            color: white !important;
            border-color: red !important;
        }
        
        /* New styles for extended scrollable content */
        .scrollable-content {
            overflow-x: auto;
            overflow-y: visible;
        }
        
        .scrollable-content .table-responsive {
            width: 1500px; /* adjust the width as needed */
        }

        /* Add this CSS style to your stylesheet */
        .sorting-options {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        /* Add this CSS style to your stylesheet */
        .sorting-options {
            position: relative;
            top: 0;
            left: 40%;
            transform: translateX(-50%);
            z-index: 1;
        }

    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Books</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('msg')): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                    <?php elseif ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">List of Books</div>
                        <div class="panel-body">
                            <div class="scrollable-content">
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>Author</th>
                                            <th>ISBN</th>
                                            <th>Content Type</th>
                                            <th>Publisher</th>
                                            <th>Program</th>
                                            <th>Book Edition</th>
                                            <th>Book Language</th>
                                            <th>Total Pages</th>
                                            <th>Year Published</th>
                                            <th>Place of Publication</th>
                                            <th>Number of Copies</th>
                                            <th>QR Code</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <!-- Sorting Options -->
                                    <div class="text-center sorting-options">
                                        <form action="<?php echo site_url('Auth/manage_books'); ?>" method="get">
                                            <label for="sort_by">Sort by:</label>
                                            <select id="sort_by" name="sort_by">
                                                <option value="none" <?php echo ($sort_by == 'none' || !isset($sort_by)) ? 'selected' : ''; ?>>None</option>
                                                <option value="RegDate" <?php echo ($sort_by == 'RegDate') ? 'selected' : ''; ?>>Book Added</option>
                                                <option value="UpdationDate" <?php echo ($sort_by == 'UpdationDate') ? 'selected' : ''; ?>>Last Book Edited</option>
                                                <option value="ProgramID" <?php echo ($sort_by == 'ProgramID') ? 'selected' : ''; ?>>Program Categories</option>
                                                <option value="NumberOfCopies" <?php echo ($sort_by == 'NumberOfCopies') ? 'selected' : ''; ?>>Number of Copies</option>
                                            </select>
                                            <label for="sort_order">Order:</label>
                                            <select id="sort_order" name="sort_order">
                                                <option value="asc" <?php echo ($sort_order == 'asc' || !isset($sort_order)) ? 'selected' : ''; ?>>Ascending</option>
                                                <option value="desc" <?php echo ($sort_order == 'desc') ? 'selected' : ''; ?>>Descending</option>
                                            </select>
                                            <button type="submit" class="btn btn-danger">Apply</button>
                                        </form>
                                    </div>

                                    <tbody>
                                        <?php if (!empty($books)) : ?>
                                            <?php $cnt = ($page - 1) * $limit + 1; foreach ($books as $book) : ?>
                                                <tr>
                                                    <td><?php echo $cnt++; ?></td>
                                                    <td>
                                                        <img 
                                                            src="<?php echo base_url('assets/bookimg/' . $book->bookImage); ?>" 
                                                            width="80" 
                                                            alt="Book Image" 
                                                            style="border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);" 
                                                        />
                                                        <br>
                                                        <strong><?php echo $book->BookName; ?></strong>
                                                    </td>
                                                    <td><?php echo $book->AuthorName; ?></td>
                                                    <td><?php echo $book->ISBNNumber; ?></td>
                                                    <td><?php echo $book->ContentType; ?></td>
                                                    <td><?php echo $book->Publisher; ?></td>
                                                    <td><?php echo $book->ProgramName; ?></td>
                                                    <td><?php echo $book->BookEdition; ?></td>
                                                    <td><?php echo $book->BookLanguage; ?></td>
                                                    <td><?php echo $book->TotalPages; ?></td>
                                                    <td><?php echo $book->YearPublished; ?></td>
                                                    <td><?php echo $book->PlaceOfPublication; ?></td>
                                                    <td><?php echo $book->NumberOfCopies; ?></td>
                                                    <td>
                                                        <?php
                                                        $qr_code_path = 'assets/qrcodes/book_' . $book->id . '.png';
                                                        if (file_exists(FCPATH . $qr_code_path)) {
                                                            echo "<img src='" . base_url($qr_code_path) . "' alt='QR Code' class='qr-code-preview' />";
                                                        } else {
                                                            echo "<span style='font-style: italic; color: grey;'>No QR Code</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                    <a 
                                                        href="<?php echo site_url('Auth/edit_book/' . $book->id); ?>" 
                                                        class="btn btn-primary btn-sm"
                                                        title="Edit Book">
                                                        <i class="fa fa-edit"></i> Edit Book
                                                    </a>
                                                    <br> 
                                                    <a 
                                                        href="<?php echo site_url('Auth/delete_book/' . $book->id); ?>" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this book?')" 
                                                        title="Delete Book">
                                                        <i class="fa fa-trash-o"></i> Delete Book
                                                    </a>
                                                    <br> 
                                                    <a 
                                                        href="javascript:void(0);" 
                                                        class="btn btn-success btn-sm print-qr-code" 
                                                        data-qr-code="<?php echo base_url('assets/qrcodes/book_' . $book->id . '.png'); ?>" 
                                                        title="Print QR Code">
                                                        <i class="fa fa-print"></i> Print QR Code
                                                    </a>
                                                    <br>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="15" style="text-align: center; font-style: italic;">No books found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <div class="pull-left">
                            <a href="<?php echo site_url('index.php'); ?>" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i> Return to Dashboard
                            </a>
                            </div>

                            <!-- Pagination -->
                            <div style="display: flex; justify-content: flex-end; width: 100%;">
                                <nav>
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&sort_by=<?php echo $sort_by; ?>&sort_order=<?php echo $sort_order; ?>">Previous</a></li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&sort_by=<?php echo $sort_by; ?>&sort_order=<?php echo $sort_order; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&sort_by=<?php echo $sort_by; ?>&sort_order=<?php echo $sort_order; ?>">Next</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="<?php echo site_url(); ?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/bootstrap.js"></script>
        <script>
        $(document).ready(function() {
            $('.print-qr-code').on('click', function() {
                var qrCodeUrl = $(this).data('qr-code');
                var printWindow = window.open('', '', 'height=500,width=500');
                printWindow.document.write('<html><head><title>QR Code</title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<img src="' + qrCodeUrl + '" style="width: 100%; height: 100%; margin: 0 auto; display: block;">');
                printWindow.document.write('</body></html>');
                printWindow.print();
                printWindow.close();
            });
        });
    </script>
</body>
</html>