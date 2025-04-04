<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Edit Program</title>
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
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
        .btn {
            border-radius: 20px;
        }
        .alert {
            border-radius: 10px;
        }
        .form-group label {
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
                    <h4 class="header-line">Edit Program</h4>
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

            <div class="panel panel-info">
                <div class="panel-heading">Program Info</div>
                <div class="panel-body">
                <form method="post" action="<?php echo site_url('Auth/edit_program/' . $program->id); ?>">
                    <div class="form-group">
                        <label>School Course</label>
                        <input 
                            type="text" 
                            name="course" 
                            class="form-control" 
                            value="<?php echo set_value('course', $program->SchoolCourse); ?>" 
                            required 
                        />
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="radio">
                            <label>
                                <input 
                                    type="radio" 
                                    name="status" 
                                    value="Active" 
                                    <?php echo ($program->Status == 'Active') ? 'checked' : ''; ?> 
                                />
                                Active
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input 
                                    type="radio" 
                                    name="status" 
                                    value="Inactive" 
                                    <?php echo ($program->Status == 'Inactive') ? 'checked' : ''; ?> 
                                />
                                Inactive
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="update" class="btn btn-info">Update</button>
                    <a href="<?php echo site_url('Auth/school_programs'); ?>" class="btn btn-warning">Cancel</a>
                </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
</body>
</html>