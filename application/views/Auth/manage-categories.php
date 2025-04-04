<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Manage Categories</title>
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/js/dataTables/dataTables.bootstrap.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .header-line {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
            text-align: center;
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
                    <h4 class="header-line">Manage Courses</h4>
                </div>
            </div>

            <?php if ($this->session->flashdata('msg')): ?>
                <div class="alert alert-success">
                    <strong>Success:</strong> <?php echo $this->session->flashdata('msg'); ?>
                </div>
            <?php elseif ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading">Course Listing</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses Name</th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                    <th>Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): $cnt = ($page - 1) * $limit + 1; ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td><?php echo $cnt++; ?></td>
                                            <td><?php echo $category->CategoryName; ?></td>
                                            <td>
                                                <a class="btn btn-<?php echo $category->Status ? 'success' : 'danger'; ?> btn-xs">
                                                    <?php echo $category->Status ? 'Active' : 'Inactive'; ?>
                                                </a>
                                            </td>
                                            <td><?php echo $category->CreationDate; ?></td>
                                            <td><?php echo $category->UpdationDate; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('Auth/edit_category/'.$category->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="<?php echo site_url('Auth/delete_category/'.$category->id); ?>" 
                                                onclick="return confirm('Are you sure you want to delete?');" 
                                                class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; font-style: italic;">No courses found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="pull-left">
                            <a href="<?php echo site_url('index.php'); ?>" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i> Return to Dashboard
                            </a>
                        </div>
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
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/dataTables/dataTables.bootstrap.js'); ?>"></script>
</body>
</html>