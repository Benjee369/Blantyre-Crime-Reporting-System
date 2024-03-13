<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title></title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">=
</head>

<body>
    <!-- nav2 -->
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
        <!-- nav2 end -->
    <div class="main-wrapper">
        <!-- side bar thing -->
        <?php
        require_once'side-bar.php';
        ?>
        <!-- end side bar thing -->
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                    <div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">Report Details</h4>
                                 <a href="appointments.php" class="btn btn-primary float-right">View all</a>
							</div>
                            <div class="card-body -0">
                       <?php
                    require_once 'DatabaseConn.php';
                    $report_id = $_GET['report_id'];

                    $query = "SELECT * FROM crimereports WHERE ID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $report_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $report_details = $result->fetch_assoc();

                        echo '<h2>' . $report_details['First_Name'] . ' ' . $report_details['Last_Name'] . '</h2>';
                        echo '<p>Incident Category: ' . $report_details['Incident_Category'] . '</p>';
                        echo '<p>Date: ' . $report_details['CurrentDate'] . '</p>';
                        echo '<p>Description: ' . $report_details['Description'] . '</p>';
                        
                    } else {
                        echo '<p>Report not found</p>';
                    }

                    $stmt->close();
                        ?> 
                <!--The form for assigning priority level adn assigning to an officer-->
                <br>
                <br>
                <?php
// Check if the admin session is set
if (isset($_SESSION['admin_id'])) {
?>

<form action="AASPL.php" method="post">
    <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">

    <label for="officer_id">Assign to Officer:</label>
    <select name="officer_id" required>
        <option value="">Select Officer</option>
        <?php
        // Fetch officers from the database
        require_once 'DatabaseConn.php';
        $query = "SELECT ID, Email FROM admindetails WHERE Role = 'officer'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $officers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        foreach ($officers as $officer) {
            echo '<option value="' . $officer['ID'] . '">' . $officer['Email'] . '</option>';
        }
        ?>
    </select>

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <label for="priority_level">Priority Level:</label>
    <select name="priority_level" required>
        <option value="">Select Priority Level</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
    </select>

    <input class="btn btn-primary float-right" type="submit" value="Assign and Set Priority">
</form>

<?php
} else {
    // Do not show the form for any other case
}
?>


                        </div>
                    </div>                    
                </div>                
                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card member-panel">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">Multimedia Attachments</h4>
							</div>
                           
                            <div class="card-footer text-center bg-white">
                                <a href="doctors.html" class="text-muted">View all Doctors</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
</body>
</html>

