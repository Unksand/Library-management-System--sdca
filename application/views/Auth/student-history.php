<!DOCTYPE html>
<html>
<head>
    <title>Online Library Management System | Student History</title>
    <link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/js/dataTables/dataTables.bootstrap.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet" />
</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">#<?= $sid; ?> Book Issued History</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?= $sid; ?> Details</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Issued Book</th>
                                            <th>Issued Date</th>
                                            <th>Returned Date</th>
                                            <th>Fine (if any)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($student_history)): ?>
                                        <?php $cnt = 1; ?>
                                        <?php foreach ($student_history as $history): ?>
                                            <tr class="odd gradeX">
                                                <td class="center"><?= $cnt++; ?></td>
                                                <td class="center"><?= htmlentities($history->StudentId); ?></td>
                                                <td class="center"><?= htmlentities($history->FullName); ?></td>
                                                <td class="center"><?= htmlentities($history->BookName); ?></td>
                                                <td class="center"><?= htmlentities($history->IssuesDate); ?></td>
                                                <td class="center"><?= $history->ReturnDate ? htmlentities($history->ReturnDate) : 'Not returned yet'; ?></td>
                                                <td class="center"><?= $history->fine ? htmlentities($history->fine) : 'Not returned yet'; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No records found</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/js/dataTables/jquery.dataTables.js'); ?>"></script>
    <script src="<?= base_url('assets/js/dataTables/dataTables.bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/js/custom.js'); ?>"></script>
</body>
</html>