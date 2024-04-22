<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

require_once 'DatabaseConn.php';

$officerQuery = "SELECT admindetails.First_Name, admindetails.Last_Name, COUNT(assignments.AssignmentID) AS AssignmentCount
                FROM admindetails
                JOIN assignments ON admindetails.ID = assignments.OfficerID
                GROUP BY admindetails.ID
                ORDER BY AssignmentCount DESC
                LIMIT 1";

// Execute the query
$officerResult = mysqli_query($conn, $officerQuery);

$officer = mysqli_fetch_assoc($officerResult);

$userQuery = "SELECT userdetails.First_Name, userdetails.Last_Name, COUNT(crimereports.ID) AS ReportCount
            FROM userdetails
            JOIN crimereports ON userdetails.ID = crimereports.UserID
            GROUP BY userdetails.ID
            ORDER BY ReportCount DESC
            LIMIT 1";

$userResult = mysqli_query($conn, $userQuery);

$user = mysqli_fetch_assoc($userResult);

$timeQuery = "SELECT HOUR(SubmittedDate) AS Hour, COUNT(ID) AS ReportCount
            FROM crimereports
            GROUP BY HOUR(SubmittedDate)
            ORDER BY ReportCount DESC
            LIMIT 1";

$timeResult = mysqli_query($conn, $timeQuery);

$time = mysqli_fetch_assoc($timeResult);

$categoryQuery = "SELECT Incident_Category, COUNT(ID) AS CategoryCount
                FROM crimereports
                GROUP BY Incident_Category
                ORDER BY CategoryCount DESC
                LIMIT 1";

$categoryResult = mysqli_query($conn, $categoryQuery);

$category = mysqli_fetch_assoc($categoryResult);

$totalReportsQuery = "SELECT COUNT(ID) AS TotalReports FROM crimereports";

$totalReportsResult = mysqli_query($conn, $totalReportsQuery);

$totalReports = mysqli_fetch_assoc($totalReportsResult);

$totalUsersQuery = "SELECT COUNT(ID) AS TotalUsers FROM userdetails";

$totalUsersResult = mysqli_query($conn, $totalUsersQuery);

$totalUsers = mysqli_fetch_assoc($totalUsersResult);

$totalOfficersQuery = "SELECT COUNT(ID) AS TotalOfficers FROM admindetails WHERE Role = 'officer'";

$totalOfficersResult = mysqli_query($conn, $totalOfficersQuery);

$totalOfficers = mysqli_fetch_assoc($totalOfficersResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Page</title>
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
    <button id="printReport" class="btn btn-primary float-right">Print/Save Report</button>
    <div class="main2-wrapper">
        <!-- side bar thing -->
        <?php
        require_once 'side-bar.php';
        ?>
        
        <div id="reportContainer">
<div class="report-section">
            <h2>Officer with Most Assignments</h2>
            <?php if($officer): ?>
            <p><?php echo $officer['First_Name'] . ' ' . $officer['Last_Name'] ?> - <?php echo $officer['AssignmentCount'] ?> assignments</p>
            <?php else: ?>
            <p>No officer found with assignments</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>User with Most Reports</h2>
            <?php if($user): ?>
            <p><?php echo $user['First_Name'] . ' ' . $user['Last_Name'] ?> - <?php echo $user['ReportCount'] ?> reports</p>
            <?php else: ?>
            <p>No user found with reports</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Time of Most Reports</h2>
            <?php if($time): ?>
            <p>Hour: <?php echo $time['Hour'] ?> - <?php echo $time['ReportCount'] ?> reports</p>
            <?php else: ?>
            <p>No reports found</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Most Common Incident Category</h2>
            <?php if($category): ?>
            <p><?php echo $category['Incident_Category'] ?> - <?php echo $category['CategoryCount'] ?> reports</p>
            <?php else: ?>
            <p>No reports found</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Total Number of Reports</h2>
            <?php if($totalReports): ?>
            <p><?php echo $totalReports['TotalReports'] ?></p>
            <?php else: ?>
            <p>No reports found</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Total Number of Users</h2>
            <?php if($totalUsers): ?>
            <p><?php echo $totalUsers['TotalUsers'] ?></p>
            <?php else: ?>
            <p>No users found</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Total Number of Officers</h2>
            <?php if($totalOfficers): ?>
            <p><?php echo $totalOfficers['TotalOfficers'] ?></p>
            <?php else: ?>
            <p>No officers found</p>
            <?php endif; ?>
        </div>
        </div>
        
    </div>
    <script>
        document.getElementById("printReport").addEventListener("click", function() {
        printReport();
        });

        function printReport() {
            var printWindow = window.open('', '_blank');
            var reportContent = document.getElementById("reportContainer").innerHTML;
            var styles = document.head.getElementsByTagName("link");
            var styleContent = '';
            for (var i = 0; i < styles.length; i++) {
                if (styles[i].rel === "stylesheet") {
                    styleContent += styles[i].outerHTML;
                }
            }
            printWindow.document.write('<html><head><title>Report</title>' + styleContent + '</head><body>' + reportContent + '</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        </script>
</body>
</html>
