<?php
// Define pagination variables
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$total_authors = count($authors);
$total_pages = ceil($total_authors / $limit);
$authors_paginated = array_slice($authors, $offset, $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authors</title>
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url();?>assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo site_url();?>assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="<?php echo site_url();?>assets/css/style.css" rel="stylesheet" />
    <style>

        body { background-color: #f8f9fa; }

        .header-line { 
            font-size: 24px; font-weight: bold; color: #343a40; margin-bottom: 20px; text-align: center; 
        }

        .panel { 
            border-radius: 10px; box-shadow: 0 2px 10px rgb(237, 91, 91); 
        }

        .panel-heading { 
            background-color: rgb(244, 98, 88) !important; color: #fff !important; font-size: 18px; font-weight: bold; border-radius: 10px 10px 0 0; text-align: center; 
        }

        .table thead th { 
            background-color: rgb(251, 109, 109); color: #fff; 
        }

        .table th, .table td { 
            text-align: center; 
        }

        .btn { 
            border-radius: 20px; 
        }

        .alert { 
            border-radius: 10px; 
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
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Authors</h4>
                </div>
            </div>

            <?php if (!empty($delmsg)) : ?>
                <div class="alert alert-success">
                    <strong>Success:</strong> <?php echo $delmsg; ?>
                </div>
            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading">Authors Listing</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Author Name</th>
                                    <th>Creation Date</th>
                                    <th>Updation Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cnt = $offset + 1; foreach ($authors_paginated as $author) : ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo $author->AuthorName; ?></td>
                                        <td><?php echo $author->creationDate; ?></td>
                                        <td><?php echo $author->UpdationDate; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('Auth/edit_author/' . $author->id); ?>" class="btn btn-primary">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?php echo site_url('Auth/delete_author/' . $author->id); ?>" 
                                            onclick="return confirm('Are you sure you want to delete?');">
                                                <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="<?php echo site_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/dataTables/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/dataTables/dataTables.bootstrap.js'); ?>"></script>
</body>
</html>