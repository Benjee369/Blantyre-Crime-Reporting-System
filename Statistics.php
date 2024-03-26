<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>
<body>
    <header class="header_section">
        <?php
        require_once'nvbr.php'; 
        ?>
    </header>
    <div class="graph-wrapper">
        <!-- side bar thing -->
        <?php
        require_once 'side-bar.php';
        ?>
    <canvas id="reportChart" width="800" height="400"></canvas>

    <?php
        // Include the database connection file
        require_once 'DatabaseConn.php';

        // Initialize variables to store report counts
        $totalReports = 0;
        $assignedReports = 0;
        $closedReports = 0;

        // Query to get the total number of reports
        $queryTotalReports = "SELECT COUNT(*) AS total_reports FROM crimereports";
        $resultTotalReports = $conn->query($queryTotalReports);

        if ($resultTotalReports) {
            $rowTotalReports = $resultTotalReports->fetch_assoc();
            $totalReports = $rowTotalReports['total_reports'];
        }

        // Query to get the number of assigned reports
        $queryAssignedReports = "SELECT COUNT(*) AS assigned_reports FROM assignments";
        $resultAssignedReports = $conn->query($queryAssignedReports);

        if ($resultAssignedReports) {
            $rowAssignedReports = $resultAssignedReports->fetch_assoc();
            $assignedReports = $rowAssignedReports['assigned_reports'];
        }

        // Query to get the number of closed reports
        $queryClosedReports = "SELECT COUNT(*) AS closed_reports FROM assignments WHERE Status = 'Closed'";
        $resultClosedReports = $conn->query($queryClosedReports);

        if ($resultClosedReports) {
            $rowClosedReports = $resultClosedReports->fetch_assoc();
            $closedReports = $rowClosedReports['closed_reports'];
        }

        // Close the database connection
        $conn->close();
    ?>



    <script>
    // Create a bar chart using Chart.js
    var ctx = document.getElementById('reportChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Reports', 'Closed Reports', 'Assigned Reports'],
            datasets: [{
                label: 'Report Statistics',
                data: [<?php echo $totalReports; ?>, <?php echo $closedReports; ?>, <?php echo $assignedReports; ?>],
                backgroundColor: [
                    '#969966',
                    '#7C9966',
                    '#998366'
                ],
                borderColor: [
                    'rgb(255, 255, 255)',
                    'rgb(255, 255, 255)',
                    'rgb(255, 255, 255)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            barPercentage: 0.5,
        }
    });
    </script>
    </div>
</body>
</html>
