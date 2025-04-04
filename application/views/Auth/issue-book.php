<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Issue a New Book</title>
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
</head>
<body>
<?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Issue a New Book</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">Issue a New Book</div>
                        <div class="panel-body">
                            <form method="post" action="<?php echo site_url('Auth/issue_book'); ?>">
                                <div class="form-group">
                                    <label>Student ID<span style="color:red;">*</span></label>
                                    <input type="text" name="studentid" id="studentid" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Book ID or ISBN<span style="color:red;">*</span></label>
                                    <input type="text" name="bookid" id="bookid" class="form-control" required>
                                </div>
                                <button type="submit" name="issue" class="btn btn-info">Issue Book</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
</body>
</html>
