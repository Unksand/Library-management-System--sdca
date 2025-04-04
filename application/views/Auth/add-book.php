<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SDCA Library Management System | Add Book</title>
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
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Add Book</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-sm-10 col-xs-12 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Book Info</div>
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

                            <form method="post" action="<?php echo site_url('Auth/add_book'); ?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Book Picture</label>
                                    <input class="form-control" type="file" name="bookpic">
                                </div>

                                <div class="form-group">
                                    <label>Book Name</label>
                                    <input class="form-control" type="text" name="bookname" required>
                                </div>

                                <!-- <div class="form-group">
                                    <label>Course</label>
                                    <select class="form-control" name="category" required>
                                        <option value="">Select Course</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category->id; ?>">
                                                <?php echo htmlspecialchars($category->CategoryName); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div> -->

                                <div class="form-group">
                                    <label>Author</label>
                                    <select class="form-control" name="author" required>
                                        <option value="">Select Author</option>
                                        <?php foreach ($authors as $author): ?>
                                            <option value="<?php echo $author->id; ?>">
                                                <?php echo htmlspecialchars($author->AuthorName); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Program</label>
                                    <select class="form-control" name="program" required>
                                        <option value="">Select Program</option>
                                        <?php foreach ($programs as $program): ?>
                                            <option value="<?php echo $program->id; ?>">
                                                <?php echo htmlspecialchars($program->SchoolCourse); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Publisher</label>
                                    <input class="form-control" type="text" name="publisher" required>
                                </div>

                                <!-- Book Edition -->
                                <div class="form-group">
                                    <label>Book Edition</label>
                                    <input class="form-control" type="text" name="bookedition" required>
                                </div>

                                <!-- Book Language -->
                                <div class="form-group">
                                    <label>Book Language</label>
                                    <input class="form-control" type="text" name="booklanguage" required>
                                </div>

                                <!-- Total Pages -->
                                <div class="form-group">
                                    <label>Total Pages</label>
                                    <input class="form-control" type="number" name="totalpages" required>
                                </div>

                                <!-- Year Published -->
                                <div class="form-group">
                                    <label>Year Published</label>
                                    <input class="form-control" type="number" name="yearpublished" required>
                                </div>

                                <!-- Place of Publication -->
                                <div class="form-group">
                                    <label>Place of Publication</label>
                                    <input class="form-control" type="text" name="placeofpublication" required>
                                </div>

                                <!-- Number of Copies -->
                                <div class="form-group">
                                    <label>Number of Copies</label>
                                    <input class="form-control" type="number" name="numberofcopies" required>
                                </div>

                                <div class="form-group">
                                    <label>ISBN Number</label>
                                    <input class="form-control" type="text" name="isbn" required>
                                </div>

                                <div class="form-group">
                                    <label>Content Type</label>
                                    <input class="form-control" type="text" name="contenttype" required>
                                </div>

                                <button type="submit" class="btn btn-danger"><i class="fa fa-plus"></i> Add Book</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="<?php echo site_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/custom.js'); ?>"></script>
</body>
</html>
