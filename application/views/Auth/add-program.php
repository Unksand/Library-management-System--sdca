<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SDCA Library Management System | Add Program</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/css/style.css'); ?>" rel="stylesheet">
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
        .form-group label {
            font-weight: bold;
            color: #343a40;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn {
            border-radius: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Add Course</h4>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8 col-sm-10 col-xs-12 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Program Info</div>
                        <div class="panel-body">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success">
                                    <strong>Success:</strong> <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?= form_open('auth/add_program') ?>
                                <div class="form-group">
                                    <label for="course">Program Name</label>
                                    <input type="text" name="course" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="Active" checked> Active
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="Inactive"> Inactive
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" name="create" class="btn btn-danger"><i class="fa fa-plus"></i> Create</button>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('includes/footer.php'); ?>
    <script src="<?php echo site_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrap.js'); ?>"></script>
</body>
</html>