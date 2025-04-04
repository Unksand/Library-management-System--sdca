<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students | Admin Dashboard</title>
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/js/dataTables/dataTables.bootstrap.css'); ?>" rel="stylesheet">
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
            background-color:rgb(244, 98, 88) !important;
            color: #fff !important;
            font-size: 18px;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .table thead th {
            background-color:rgb(251, 109, 109);
            color: #fff;
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
                    <h4 class="header-line">Manage Registered Students</h4>
                </div>
            </div>

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
                <div class="panel-heading">Registered Students</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>School ID</th>
                                    <th>Name</th>
                                    <th>School Email</th>
                                    <th>Mobile</th>
                                    <th>Registration Date</th>
                                    <th>School Program</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($student as $index => $s): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $s->StudentId; ?></td>
                                        <td><?php echo $s->FullName; ?></td>
                                        <td><?php echo $s->EmailId; ?></td>
                                        <td><?php echo $s->MobileNumber; ?></td>
                                        <td><?php echo $s->RegDate; ?></td>
                                        <td><?php echo $s->SchoolProgram; ?></td>
                                    </tr>
                                <?php endforeach; ?>
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