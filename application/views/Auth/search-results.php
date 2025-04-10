<!-- search-results.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Search Results</title>
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
                    <h4 class="header-line">Search Results</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <form action="<?= base_url('auth/search_books') ?>" method="get">
                        <div class="form-group">
                            <label for="search">Search for a book:</label>
                            <select name="search_field" class="form-control">
                                <option value="book_name">Book Name</option>
                                <option value="author">Author</option>
                                <option value="isbn_number">ISBN Number</option>
                            </select>
                            <input type="text" name="search" placeholder="Enter search term..." class="form-control">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if (empty($results)) : ?>
                        <p>No results found.</p>
                    <?php else : ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">List of Search Results</div>
                            <div class="panel-body">
                                <div class="scrollable-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Book Image</th>
                                                    <th>Book Name</th>
                                                    <th>ISBN Number</th>
                                                    <th>Author Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($results as $result) : ?>
                                                    <tr>
                                                        <td>
                                                            <img 
                                                                src="<?php echo base_url('assets/bookimg/' . $result->bookImage); ?>" 
                                                                width="80" 
                                                                alt="Book Image" 
                                                                style="border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);" 
                                                            />
                                                        </td>
                                                        <td><?= $result->BookName ?></td>
                                                        <td><?= $result->ISBNNumber ?></td>
                                                        <td><?= $result->AuthorName ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="<?php echo site_url(); ?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/bootstrap.js"></script>
</body>
</html>