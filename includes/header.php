<div class="navbar navbar-inverse set-radius-zero shadow-lg">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">
                <img src="<?php echo base_url('assets/img/logo-header.png'); ?>" class="animated-logo" alt="Logo">
            </a>
        </div>

        <div class="right-div">
            <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-primary pull-right btn-logout">LOG ME OUT</a>
        </div>
    </div>
</div>

<!-- LOGO HEADER END -->
<section class="menu-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-collapse collapse">
                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo site_url('auth/index'); ?>" class="menu-top-active">DASHBOARD</a></li>

                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Courses <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu animated-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/add_category'); ?>">Add Book Course</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/manage_categories'); ?>">Manage Book Courses</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Authors <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu animated-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/add_author'); ?>">Add Author</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/manage_authors'); ?>">Manage Authors</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Books <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu animated-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/add_book'); ?>">Add Book</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/manage_books'); ?>">Manage Books</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/manage_issued_books'); ?>">Manage Issued Books</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">School Course <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu animated-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/add_program'); ?>">Issue New Course</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('auth/school_programs'); ?>">Manage School course</a></li>
                            </ul>
                        </li>
                        <li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('Auth/reg-students'); ?>">Reg Students</a></li>
                        </li>
                        <li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('Auth/reg-staff'); ?>">Reg Staff</a></li>
                        </li><li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('Auth/analytics'); ?>">Analytics</a></li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
    .navbar {
        background-color:rgb(255, 255, 255); /* Deep red for header background */
        border-radius: 0;
        border-bottom: 3px solid #ff6b6b; /* Lighter red accent */
    }

    .navbar-brand img {
        height: 70px;
        width: auto;
        animation: fadeIn 1.2s ease-in-out;
    }

    .right-div .btn-logout {
        background-color: #ff6b6b;
        color: #fff;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-logout:hover {
        background-color: #c92a2a;
        transform: scale(1.1);
    }

    .menu-section {
    background: rgb(255, 255, 255); /* Background for the section */
    padding: 10px 0;
    box-shadow: 0 4px 8px rgb(255, 4, 4); /* Red shadow */
    border-bottom: 4px solid #c92a2a; /* Red underline */
    }

    #menu-top .nav > li > a {
        color: #c92a2a; /* Red links */
        font-weight: bold;
        padding: 10px 15px;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    #menu-top .nav > li > a:hover,
    #menu-top .menu-top-active {
        color:rgb(248, 32, 32);
        background-color:rgb(255, 255, 255); /* Highlighted red background */
        border-radius: 4px;
    }

    .dropdown-menu.animated-menu {
        background-color: #ffffff;
        border: 1px solid #c92a2a;
        animation: dropdownFade 0.3s ease-in-out;
    }

    .dropdown-menu.animated-menu > li > a {
        color: #c92a2a; /* Red text for dropdown items */
        font-weight: bold;
    }

    .dropdown-menu.animated-menu > li > a:hover {
        background-color: #c92a2a; /* Red background on hover */
        color: #ffffff;
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
