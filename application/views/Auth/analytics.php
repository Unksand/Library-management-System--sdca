<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Analytics Dashboard" />
    <meta name="author" content="St Dominic College of Asia" />
    <title>SDCA Library Management System | Analytics</title>
    <link href="<?php echo site_url();?>assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo site_url();?>assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo site_url();?>assets/css/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <?php include('includes/header.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <h4 class="header-line">LIBRARY ANALYTICS DASHBOARD</h4>
            <div class="dashboard-widgets">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-success text-center">
                            <i class="fa fa-book fa-5x"></i>
                            <h3><?php echo $books_count ?? 0; ?></h3>
                            Books Listed
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-warning text-center">
                            <i class="fa fa-recycle fa-5x"></i>
                            <h3><?php echo $not_returned_count ?? 0; ?></h3>
                            Books Not Returned Yet
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-danger text-center">
                            <i class="fa fa-users fa-5x"></i>
                            <h3><?php echo isset($staff_count) ? $staff_count : 0; ?></h3>
                            Registered Students
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-success text-center">
                            <i class="fa fa-users fa-5x"></i>
                            <h3><?php echo $staff_count ?? 0; ?></h3>
                            Registered Staff
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-info text-center">
                            <i class="fa fa-user fa-5x"></i>
                            <h3><?php echo $author_count ?? 0; ?></h3>
                            Authors Listed
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-chart animate__animated animate__fadeInUp">
                    <canvas id="dashboardChart"></canvas>
                </div>
                <div class="print-button-container text-right" style="margin-bottom: 20px;">
                    <button onclick="printChart()" class="btn btn-primary">
                        <i class="fa fa-print"></i> Print Chart
                    </button>
                    <button onclick="saveChart()" class="btn btn-success">
                    <i class="fa fa-save"></i> Save Chart
                    </button>
                </div>
            </div>
        </div>
    </div>


    <?php include('includes/footer.php'); ?>

    <!-- Scripts -->
    <script src="<?php echo site_url();?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo site_url();?>assets/js/bootstrap.js"></script>
    <script src="<?php echo site_url();?>assets/js/custom.js"></script>

    <script>
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        const dashboardChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Books Listed', 'Books Not Returned', 'Registered Students', 'Authors Listed', 'Registered Staff'],
        datasets: [{
            label: 'Counts',
            data: [
                <?php echo $books_count; ?>,
                <?php echo $not_returned_count; ?>,
                <?php echo $staff_count; ?>,
                <?php echo $author_count; ?>,
                <?php echo $category_count; ?>,
                <?php echo $staff_count; ?>
            ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            ticks: {
                font: {
                    size: 14
                }
            },
            grid: {
                display: false
            }
        },
        y: {
            beginAtZero: true,
            ticks: {
                font: {
                    size: 14
                },
                stepSize: 5, // Set the step size to 5
                max: 25 // Set the maximum value to 25
            }
        }
    },
    plugins: {
        legend: {
            display: true,
            labels: {
                font: {
                    size: 14
                }
            }
        },
        tooltip: {
            enabled: true,
            backgroundColor: 'rgba(0,0,0,0.7)',
            titleFont: {
                size: 16
            },
            bodyFont: {
                size: 14
            }
        },
        title: {
            display: true,
            text: 'Library Analytics Overview',
            font: {
                size: 18,
                weight: 'bold'
            }
        }
    }
    }});

    function printChart() {
        const chartData = JSON.stringify(dashboardChart.data);
        const chartOptions = JSON.stringify(dashboardChart.options);
        const date = new Date().toLocaleDateString();

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
            <head>
                <title>Print Chart</title>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"><\/script>
                <style>
                    body { text-align: center; font-family: Arial, sans-serif; }
                    canvas { 
                        margin: 20px auto; 
                        display: block;
                        width: 800px; /* Set a fixed width */
                        height: 100px; /* Set a fixed height */
                    }
                    h3 { font-size: 24px; margin: 5px 0; }
                    .header img {
                        width: 50%;
                        height: auto;
                        margin: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <img src="<?php echo site_url();?>assets/img/logo-header.png" alt="School Logo">
                    <h2>DLRC library analytics</h2>
                    <p>Email: [dlrchelpdesk@sdca.edu.ph] </p>
                </div>
                <h3>Library Analytics Overview as of ${date}</h3>
                <canvas id="printChart"></canvas>
                <script>
                    const ctx = document.getElementById('printChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: ${chartData},
                        options: ${chartOptions}
                    });
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.onload = function () {
            printWindow.print();
            printWindow.close();
        };
        }

        function saveChart() {
            const canvas = document.getElementById('dashboardChart');
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/jpg');
            link.download = 'library_analytics_chart.jpg';
            link.click();
        }

    </script>

</body>
</html>