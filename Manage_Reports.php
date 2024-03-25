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
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>

<body>
    <header class="header_section">
        <?php
        require_once'nvbr.php'; 
        ?>
    </header>
    <div class="main-wrapper">
        <!-- side bar thing -->
        <?php
        require_once'officer_side_bar.php';
        ?>
        <!-- end side bar thing -->
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Manage all the Police Reports</h4>
                    </div>
                  </div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped custom-table">
								<thead>
									<tr>
										<th>Report ID</th>
										<th>Reporter Name</th>
										<th>Number of People Involved</th>
										<th>Assigned Officer</th>
										<th>Incident Category</th>
										<th>Submission Time</th>
										<th>Wittnessed Time</th>
										<th>Priority Level</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									
                                    <?php
                        require_once 'DatabaseConn.php';

                        // Retrieve officer ID from session
                        if (isset($_SESSION['officer_id']) && !empty($_SESSION['officer_id'])) {
                            $officer_id = $_SESSION['officer_id'];

                            // Prepare and execute SQL query with officer ID parameter
                            $query = "SELECT crimereports.*
                                      FROM crimereports
                                      INNER JOIN assignments ON crimereports.ID = assignments.ReportID
                                      WHERE assignments.OfficerID = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $officer_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $incident_reports = $result->fetch_all(MYSQLI_ASSOC);
                                foreach ($incident_reports as $incident_report) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo '<h2><a href="profile.html">' . $incident_report['ID'] . '</a></h2>';
                                    echo '</td>';
        
                                    echo '<td>';
                                    echo '<h2><a href="profile.html">' . $incident_report['First_Name'] . ' ' . $incident_report['Last_Name'] . '</a></h2>';
                                    echo '</td>';
        
                                    echo '<td>';
                                    echo '<p>' . $incident_report['People_Involved'] . '</p>';
                                    echo '</td>';
        
                                    echo '<td>';
                                    echo '<p>' . $incident_report['CurrentDate'] . '</p>';
                                    echo '</td>';
        
                                    echo '<td>';
                                    echo '<p>' . $incident_report['Incident_Category'] . '</p>';
                                    echo '</td>';
        
                                    echo '<td>';
                                    echo '<p>' . $incident_report['CurrentDate'] . '</p>';
                                    echo '</td>';
        
                                    echo '<td>';
                                    echo '<p>' . $incident_report['WitnessedDate'] . '</p>';
                                    echo '</td>';
        
                                    echo '</tr>';
                                }
                            } else {
                                echo '<p class="no_review">No Reviews available at the moment,<br>
                                Be the first To leave a Review.</p>';
                            }
                            $stmt->close();
                        } else {
                            echo '<p>Officer ID not found in session.</p>';
                        }
                        $conn->close();            
                    ?>
								</tbody>
							</table>
						</div>
					</div>
                </div>
            </div>
		</div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
