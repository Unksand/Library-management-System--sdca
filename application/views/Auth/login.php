<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Muhamad Nauval Azhar">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SDCA Library Admin</title>
    <link rel="stylesheet" href="<?php echo site_url('assets/all.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/toast/toast.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="<?php echo site_url('assets/toast/jqm.js'); ?>"></script>
    <script src="<?php echo site_url('assets/toast/toast.js'); ?>"></script>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(-45deg,rgba(255, 112, 69, 0.92),rgba(231, 60, 126, 0.9),rgba(255, 5, 5, 0.87),rgba(251, 255, 4, 0.78));
            background-size: 400% 400%;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .card-header {
            background: linear-gradient(135deg, #f76c6c, #f7797d);
            text-align: center;
            padding: 2rem 0;
            color: white;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header img {
            width: 250px;
            margin-bottom: 1rem;
        }

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
        }

        .card-body {
            padding: 20px;
            background: #f7f7f7;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.75rem;
            transition: all 0.3s ease;
            height: 50px;
        }

        .form-control:focus {
            border-color: #f76c6c;
            box-shadow: 0 0 5px rgba(247, 108, 108, 0.5);
        }

        .btn {
            background: linear-gradient(135deg, #f76c6c, #f7797d);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 5px;
            width: 100%;
            font-size: 1rem;
            transition: all 0.3s ease;
            height: 50px;
        }

        .btn:hover {
            background: linear-gradient(135deg, #f7797d, #f76c6c);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-dark {
            color: #f76c6c !important;
            font-weight: bold;
        }

        .text-dark:hover {
            text-decoration: underline;
        }

        .card-footer {
            text-align: center;
            font-size: 0.9rem;
            background: #f7f7f7;
            padding: 1rem 0;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .animate__animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .animate__fadeIn {
            animation-name: fadeIn;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="card shadow-lg animate__animated animate__fadeIn">
        <div class="card-header">
            <img src="<?php echo site_url('assets/img/logo-header.png'); ?>" alt="logo">
            <h1>Welcome Back!</h1>
        </div>
        <div class="card-body">
            <h1 class="fs-4 card-title fw-bold mb-4">Admin Login</h1>
            <?php echo form_open('Auth/login_form'); ?>
                <div class="mb-3">
                    <label class="mb-2 text-muted" for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="mb-2 text-muted" for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn">Login</button>
                </div>
            <?php echo form_close(); ?>
        </div>
        <div class="card-footer">
            <p class="text-muted">&copy; 2025 St Dominic College of Asia</p>
        </div>
    </div>

    <script>
        <?php if ($this->session->flashdata('worng')): ?>
            toastr.error("<?php echo $this->session->flashdata('worng'); ?>");
        <?php elseif ($this->session->flashdata('suc')): ?>
            toastr.success("<?php echo $this->session->flashdata('suc'); ?>");
        <?php endif; ?>
    </script>
</body>
</html>