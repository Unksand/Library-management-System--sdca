<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Admin Dashboard" />
    <meta name="author" content="St Dominic College of Asia" />
    <title>SDCA Library Management System | Admin Dashboard</title>
    <link href="<?php echo site_url();?>assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo site_url();?>assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo site_url();?>assets/css/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    /* Existing Styles */
    body {
        background-color: rgb(223, 223, 227);
        font-family: 'Open Sans', sans-serif;
    }

    .content-wrapper {
        padding: 20px;
    }

    .header-line {
        color: rgb(247, 33, 33);
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 4px solid rgb(249, 63, 43);
        padding-bottom: 10px;
        text-align: center;
    }

    /* Hover Animations */
    .dashboard-widgets a {
        text-decoration: none;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .dashboard-widgets a:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        animation: glowEffect 0.5s ease-in-out;
    }

    .back-widget-set {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 20px;
        background: linear-gradient(145deg, #ffffff, #e6e6e6);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .back-widget-set:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        transform: scale(1.05);
    }

    @keyframes glowEffect {
        0% {
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.1);
        }
        50% {
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
        }
        100% {
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.1);
        }
    }

    .print-button-container button {
        transition: all 0.3s ease-in-out;
    }

    .print-button-container button:hover {
        background-color: rgb(252, 48, 48);
        transform: scale(1.1);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .dashboard-chart {
        flex: 2;
        margin: 20px 0;
        height: 400px;
        width: 100%;
        background: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .dashboard-chart:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
</style>
</head>
<body>
    <!-- MENU SECTION -->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END -->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">LIBRARY ADMIN DASHBOARD</h4>
                </div>
            </div>

            <!-- Search Bar -->
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

            <div class="dashboard-content">
                <!-- Widgets Section -->
                <div class="dashboard-widgets">
                    <div class="row">
                        <a href="<?php echo site_url('Auth/manage_books'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-success back-widget-set text-center">
                                    <i class="fa fa-book fa-5x"></i>
                                    <h3><?php echo isset($books_count) ? $books_count : 0; ?></h3>
                                    Books Listed
                                </div>
                            </div>
                        </a>

                        <!-- Books Not Returned -->
                        <a href="<?php echo site_url('Auth/manage_issued_books'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-warning back-widget-set text-center">
                                    <i class="fa fa-recycle fa-5x"></i>
                                    <h3><?php echo isset($not_returned_count) ? $not_returned_count : 0; ?></h3>
                                    Books Not Returned Yet
                                </div>
                            </div>
                        </a>

                        <!-- Registered Students -->
                        <a href="<?php echo site_url('Auth/reg-students'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-danger back-widget-set text-center">
                                    <i class="fa fa-users fa-5x"></i>
                                    <h3><?php echo isset($staff_count) ? $staff_count : 0; ?></h3>
                                    Registered Students
                                </div>
                            </div>
                        </a>

                        <!-- Registered Staffs -->
                        <a href="<?php echo site_url('Auth/reg-staff'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-primary back-widget-set text-center">
                                    <i class="fa fa-users fa-5x"></i>
                                    <h3><?php echo isset($staff_count) ? $this->Staff_model->get_staff_count() : 0; ?></h3>
                                    Registered Staff
                                </div>
                            </div>
                        </a>

                        <!-- Authors Listed -->
                        <a href="<?php echo site_url('Auth/manage_authors'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-success back-widget-set text-center">
                                    <i class="fa fa-user fa-5x"></i>
                                    <h3><?php echo isset($author_count) ? $author_count : 0; ?></h3>
                                    Authors Listed
                                </div>
                            </div>
                        </a>

                        <!-- Listed Courses -->
                        <a href="<?php echo site_url('Auth/manage_categories'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-warning back-widget-set text-center">
                                    <i class="fa fa-file-archive-o fa-5x"></i>
                                    <h3><?php echo isset($category_count) ? $category_count : 0; ?></h3>
                                    Listed Courses
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo site_url('Auth/school_programs'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-danger back-widget-set text-center">
                                    <i class="fas fa-graduation-cap fa-5x"></i>
                                    <h3><?php echo isset($program_count) ? $program_count : 0; ?></h3>
                                    School Programs
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo site_url('Auth/analytics'); ?>" class="animate__animated animate__fadeIn">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="alert alert-primary back-widget-set text-center">
                                    <i class="fas fa-poll fa-5x"></i>
                                    <h3>Analytics</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include('includes/footer.php'); ?>

    <!-- Scripts -->
    <script src="<?php echo site_url();?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo site_url();?>assets/js/bootstrap.js"></script>
    <script src="<?php echo site_url();?>assets/js/custom.js"></script>
</body>
</html>