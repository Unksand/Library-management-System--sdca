<?php
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Book</title>
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url(); ?>assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo site_url(); ?>assets/css/style.css" rel="stylesheet" />
    <style>
        
        body {
            background-color: #f4f6f9;
        }

        .header-line {
            color: rgb(77, 78, 79);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .panel {
            border: none;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .panel-heading {
            background-color: rgb(254, 89, 52);
            color: #ffffff;
            padding: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .panel-body {
            padding: 30px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: rgb(26, 205, 255);
        }

        .qr-code-container {
            text-align: center;
            margin-top: 30px;
        }

        .qr-code-container img {
            border: 2px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="header-line">Edit Book</h4>
                </div>
            </div>

            <!-- Success/Error Message -->
            <?php if (!empty($this->session->flashdata('msg'))) : ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            <?php elseif (!empty($this->session->flashdata('error'))) : ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="panel">
                <div class="panel-heading">Book Information</div>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data" class="form-container">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Book Image -->
                                <div class="form-group">
                                    <label>Book Image:</label>
                                    <img src="<?php echo base_url('assets/bookimg/' . $book->bookImage); ?>" alt="Book Image" style="width: 120px;">
                                    <input type="file" name="bookImage" class="form-control">
                                    <input type="hidden" name="old_book_image" value="<?php echo $book->bookImage; ?>">
                                </div>

                                <!-- Book Name -->
                                <div class="form-group">
                                    <label>Book Name</label>
                                    <input type="text" id="bookname" name="bookname" class="form-control" value="<?php echo set_value('bookname', $book->BookName); ?>" required>
                                </div>

                                <!-- ISBN -->
                                <div class="form-group">
                                    <label>ISBN</label>
                                    <input type="text" id="isbn" name="isbn" class="form-control" value="<?php echo set_value('isbn', $book->ISBNNumber); ?>" required>
                                </div>

                                <!-- Content Type -->
                                <div class="form-group">
                                    <label>Content Type</label>
                                    <input type="text" id="content-type" name="content-type" class="form-control" value="<?php echo set_value('content-type', $book->ContentType); ?>" required>
                                </div>

                                <!-- Publisher -->
                                <div class="form-group">
                                    <label>Publisher</label>
                                    <input type="text" id="publisher" name="publisher" class="form-control" value="<?php echo set_value('publisher', $book->Publisher); ?>" required>
                                </div>

                                <!-- Category -->
                                <!--<div class="form-group">
                                    <label>Category</label>
                                    <select id="category" name="category" class="form-control">
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?php echo $category->id; ?>" <?php echo set_select('category', $category->id, $category->id == $book->CatId); ?>>
                                                <?php echo $category->CategoryName; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div> -->

                                <!-- Author -->
                                <div class="form-group">
                                    <label>Author</label>
                                    <input type="text" id="author" name="author" class="form-control" value="<?php echo set_value('author', $book->AuthorName); ?>" required>
                                    <div id="author-suggestions" style="display: none;"></div>
                                </div>

                                <!-- Program -->
                                <div class="form-group">
                                    <label>Program</label>
                                    <select id="program" name="program" class="form-control">
                                        <?php foreach ($programs as $program) : ?>
                                            <option value="<?php echo $program->id; ?>" <?php echo set_select('program', $program->id, $program->id == $book->ProgramID); ?>>
                                                <?php echo $program->SchoolCourse; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6" style="margin-top: 210px;">
                                <div class="form-group">
                                    <label>Book Edition</label>
                                    <input type="text" id="bookedition" name="bookedition" class="form-control" value="<?php echo set_value('bookedition', $book->BookEdition); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Book Language</label>
                                    <input type="text" id="booklanguage" name="booklanguage" class="form-control" value="<?php echo set_value('booklanguage', $book->BookLanguage); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Total Pages</label>
                                    <input type="number" id="totalpages" name="totalpages" class="form-control" value="<?php echo set_value('totalpages', $book->TotalPages); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Year Published</label>
                                    <input type="number" id="yearpublished" name="yearpublished" class="form-control" value="<?php echo set_value('yearpublished', $book->YearPublished); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Place of Publication</label>
                                    <input type="text" id="placeofpublication" name="placeofpublication" class="form-control" value="<?php echo set_value('placeofpublication', $book->PlaceOfPublication); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Number of Copies</label>
                                    <input type="number" id="numberofcopies" name="numberofcopies" class="form-control" value="<?php echo set_value('numberofcopies', $book->NumberOfCopies); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Update Button -->
                        <button type="submit" name="update" class="btn btn-primary btn-block">Update</button>
                        <a href="<?php echo site_url('Auth/manage_books'); ?>" class="btn btn-danger btn-block">Return to Manage Books</a>
                    </form>

                    <!-- QR Code Preview -->
                    <div class="form-group text-center">
                        <label for="generate_qr">QR Code Preview</label>
                        <div id="qr-preview" class="qr-code-container">
                        <?php
                            $writer = new PngWriter();
                            //$categoryName = '';
                            $authorName = '';
                            $programName = '';

                            //foreach ($categories as $category) {
                                //if ($category->id == $book->CatId) {
                                    //$categoryName = $category->CategoryName;
                                    //break;
                               // }
                            //}

                            foreach ($authors as $author) {
                                if ($author->id == $book->AuthorId) {
                                    $authorName = $author->AuthorName;
                                    break;
                                }
                            }

                            foreach ($programs as $program) {
                                if ($program->id == $book->ProgramID) {
                                    $programName = $program->SchoolCourse;
                                    break;
                                }
                            }

                            $qrCodeData = 'Book ID: ' . $book->id . "\nBook Name: " . $book->BookName . "\nISBN: " . $book->ISBNNumber . "\nContent Type: " . $book->ContentType . "\nPublisher: " . $book->Publisher . "\nAuthor: " . $authorName . "\nProgram: " . $programName . "\nBook Edition: " . $book->BookEdition . "\nBook Language: " . $book->BookLanguage . "\nTotal Pages: " . $book->TotalPages . "\nYear Published: " . $book->YearPublished . "\nPlace of Publication: " . $book->PlaceOfPublication . "\nNumber of Copies: " . $book->NumberOfCopies;
                            $hashedQrCodeData = hash('sha256', $qrCodeData);

                            $qrCode = new QrCode($hashedQrCodeData);
                            $qrCode->setEncoding(new Encoding('UTF-8'));
                            $qrCode->setSize(300);
                            $qrCode->setMargin(10);
                            $qrCode->setForegroundColor(new Color(0, 0, 0));
                            $qrCode->setBackgroundColor(new Color(255, 255, 255));

                            $result = $writer->write($qrCode);
                            echo '<img src="/login/assets/qrcodes/book_' . $book->id . '.png">';
                            $result->saveToFile('assets/qrcodes/book_' . $book->id . '.png');
                        ?>

                        </div>
                        <div class="text-center">
                            <button id="generate-qr" class="btn btn-primary">Generate QR Code</button>
                            <button id="delete-qr" class="btn btn-danger">Delete QR Code</button>
                        </div>
                        <input type="hidden" id="book-id" value="<?php echo $book->id; ?>">
                        <input type="hidden" id="hashed-qr-code-data" value="<?php echo $hashedQrCodeData; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo site_url(); ?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/bootstrap.js"></script>
    <script>
    $(document).ready(function () {
        $('#generate-qr').on('click', function () {
        const bookName = $('#bookname').val();
        const isbn = $('#isbn').val();
        const contentType = $('#content-type').val();
        const publisher = $('#publisher').val();
        const author = $('#author').val();
        const program = $('#program').val();
        const bookId = $('#book-id').val();
        const bookEdition = $('#bookedition').val();
        const bookLanguage = $('#booklanguage').val();
        const totalPages = $('#totalpages').val();
        const yearPublished = $('#yearpublished').val();
        const placeOfPublication = $('#placeofpublication').val();
        const numberOfCopies = $('#numberofcopies').val();

        if (!bookName || !isbn || !contentType || !publisher || !category || !author || !program) {
            alert('Please fill in all fields before generating the QR code.');
            return;
        }

        const qrData = JSON.stringify({
            BookID: bookId,
            BookName: bookName,
            ISBN: isbn,
            ContentType: contentType,
            Publisher: publisher,
            AuthorID: author,
            ProgramID: program,
            BookEdition: bookEdition,
            BookLanguage: bookLanguage,
            TotalPages: totalPages,
            YearPublished: yearPublished,
            PlaceOfPublication: placeOfPublication,
            NumberOfCopies: numberOfCopies,
        });

    const qrCodePath = 'assets/qrcodes/book_' + bookId + '.png';

    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('Auth/generate_qr_code'); ?>',
        data: { qr_data: qrData, qr_code_path: qrCodePath },
        success: function (response) {
            if (response.success) {
                $('#qr-preview').html('<img src="<?php echo base_url('assets/qrcodes/book_' . $book->id . '.png'); ?>" alt="QR Code">');
            } else {
                alert('Failed to generate QR code.');
            }
        }
    });
});

    $('#author').on('keyup', function () {
        const authorName = $(this).val();
        if (authorName.length > 2) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('Auth/get_authors'); ?>',
                data: { author_name: authorName },
                success: function (response) {
                    const authors = JSON.parse(response);
                    const suggestionsHtml = authors.map(author => `<div class="suggestion">${author.AuthorName}</div>`).join('');
                    $('#author-suggestions').html(suggestionsHtml).show();
                }
            });
        } else {
            $('#author-suggestions').hide();
        }
    });

    $(document).on('click', '.suggestion', function () {
        const authorName = $(this).text();
        $('#author').val(authorName);
        $('#author-suggestions').hide();
    });

    $('#delete-qr').on('click', function () {
    if (confirm('Are you sure you want to delete the QR code?')) {
        const qrCodePath = 'assets/qrcodes/book_' + <?php echo $book->id; ?> + '.png';
        const hashedQrCodeData = $('#hashed-qr-code-data').val();
        const bookId = <?php echo $book->id; ?>;

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('Auth/delete_qr_code'); ?>',
            data: { qr_code_path: qrCodePath, hashed_qr_code_data: hashedQrCodeData, book_id: bookId },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    $('#qr-preview').html('');
                    alert(data.message);
                    window.location.href = '<?php echo site_url('Auth/manage_books'); ?>';
                } else {
                    alert(data.error);
                }
            }
        });
    }
    });
    });
    </script>
</body>
</html>