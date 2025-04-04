<!DOCTYPE html>
<html>
<head>
    <title>Issued Book Details</title>
    <link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet" />
    <style>
        .details-box {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .details-header {
            background-color: rgb(248, 85, 85);
            padding: 10px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px 5px 0 0;
            color: #fff;
            margin-bottom: 15px;
        }
        .details-content {
            padding: 10px 0;
            text-align: center;
        }
        .details-content p {
            margin: 10px 0;
            font-size: 18px;
            line-height: 1.8;
            word-spacing: 5px; /* Add spaces between words */
        }
        .details-content img {
            margin-bottom: 25px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
        }
        .details-col {
            flex: 1;
            margin-right: 15px;
        }
        .details-col:last-child {
            margin-right: 0;
        }
        .btn-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <h4 class="header-line">Issued Book Details</h4>

        <!-- Student Details -->
        <div class="details-box">
            <div class="details-header">Student Details</div>
            <div class="details-content">
                <div class="details-row">
                    <div class="details-col">
                        <p><strong>Student ID:</strong> <?= $book_details['StudentId']; ?></p>
                        <p><strong>Student Email Id:</strong> <?= $book_details['EmailId']; ?></p>
                        <p><strong>School Branch:</strong> <?= $book_details['FullName']; ?></p> <!-- CHANGE LATER -->
                    </div>
                    <div class="details-col">
                        <p><strong>Student Name:</strong> <?= $book_details['FullName']; ?></p>
                        <p><strong>Course:</strong> <?= $book_details['FullName']; ?></p> <!-- CHANGE LATER -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="details-box">
            <div class="details-header">Book Details</div>
            <div class="details-content">
                <div class="details-row">
                    <div class="details-col" style="flex: 0.3;">
                        <img 
                            src="<?= base_url('assets/bookimg/' . $book_details['bookImage']); ?>" 
                            width="150" 
                            alt="Book Image" 
                            onerror="this.src='<?= base_url('assets/bookimg/default-book.png'); ?>';" 
                        />
                    </div>
                    <div class="details-col" style="flex: 0.7;">
                        <p><strong>Book Name:</strong> <?= $book_details['BookName']; ?></p>
                        <p><strong>ISBN:</strong> <?= $book_details['ISBNNumber']; ?></p>
                        <p><strong>Book Issued Date:</strong> <?= $book_details['IssuesDate']; ?></p>
                        <p><strong>Book Returned Date:</strong> 
                            <?= $book_details['ReturnDate'] ? $book_details['ReturnDate'] : 'Not Returned Yet'; ?>
                        </p>
                        <div class="btn-container">
                            <a href="<?= base_url('auth/manage_issued_books'); ?>" class="btn btn-info">Back to Manage Issued Books</a>
                            <?php if ($book_details['RetrunStatus'] == 0) { ?>
                                <a href="<?= base_url('auth/return_book/' . $book_details['bid']); ?>" class="btn btn-info" onclick="return confirm('Are you sure you want to return this book?');">Return</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php include('includes/footer.php'); ?>

    <script src="<?= base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.js'); ?>"></script>
</body>
</html>
