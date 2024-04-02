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
    <title>Preclinic - Medical & Hospital - Bootstrap 4 Admin Template</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
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
        require_once 'side-bar.php';
        ?>
        <!-- end side bar thing -->

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="dash-widget">   
                        <div class="dash-widget-info text-right">
                        <?php
                            require_once 'DatabaseConn.php';

                            $query_total_crimes = "SELECT COUNT(*) AS total_crimes FROM crimereports";
                            $stmt_total_crimes = $conn->prepare($query_total_crimes);
                            $stmt_total_crimes->execute();
                            $result_total_crimes = $stmt_total_crimes->get_result();

                            if ($result_total_crimes->num_rows > 0) {
                                $total_crimes = $result_total_crimes->fetch_assoc()['total_crimes'];
                                echo '<h3>' . $total_crimes . '</h3>';
                            } else {
                                echo '<h3>0</h3>'; // Default value if no data available
                            }
                            $stmt_total_crimes->close();
                        ?>

                            <span class="widget-title1">Crimes Reported</span>
                        </div>
                    </div>
                </div>


                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="dash-widget">
                            <div class="dash-widget-info text-right">
                            <?php
                                require_once 'DatabaseConn.php';

                                // Fetch total number of crimes reported
                                $query_total_crimes = "SELECT COUNT(*) AS assigned_reports FROM assignments";
                                $stmt_total_officers = $conn->prepare($query_total_crimes);
                                $stmt_total_officers->execute();
                                $result_total_officers = $stmt_total_officers->get_result();

                                if ($result_total_officers->num_rows > 0) {
                                    $total_officers = $result_total_officers->fetch_assoc()['assigned_reports'];
                                    echo '<h3>' . $total_officers . '</h3>';
                                } else {
                                    echo '<h3>0</h3>';
                                }
                                $stmt_total_officers->close();
                            ?>

                                <span class="widget-title2">Reports Assigned</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="dash-widget">
                            <div class="dash-widget-info text-right">
                                <?php
                                    require_once 'DatabaseConn.php';

                                    // Fetch total number of crimes reported
                                    $query_total_crimes = "SELECT COUNT(*) AS total_officers FROM admindetails WHERE Role='officer'";
                                    $stmt_total_officers = $conn->prepare($query_total_crimes);
                                    $stmt_total_officers->execute();
                                    $result_total_officers = $stmt_total_officers->get_result();

                                    if ($result_total_officers->num_rows > 0) {
                                        $total_officers = $result_total_officers->fetch_assoc()['total_officers'];
                                        echo '<h3>' . $total_officers . '</h3>';
                                    } else {
                                        echo '<h3>0</h3>';
                                    }
                                    $stmt_total_officers->close();
                                ?>
                                <span class="widget-title3">Available Officers</span>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="row">
					<div class="main-card-thing">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">Latest Reports</h4> <a href="View_Reports.php" class="btn btn-primary float-right">View all</a>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table mb-0">
										<tbody>
                                        <?php
                        require_once 'DatabaseConn.php';

                        $query = "SELECT * 
                        FROM crimereports 
                        WHERE ID 
                        NOT IN (SELECT ReportID FROM assignments)";
                    

                    $stmt = $conn->prepare($query);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $incident_reports = $result->fetch_all(MYSQLI_ASSOC);
                        foreach ($incident_reports as $incident_report) {
                            echo '<tr>';
                            echo '<td style="min-width: 200px;">';
                            echo '<h2><a href="Manage_Users.php">' . $incident_report['First_Name'] . ' ' . $incident_report['Last_Name'] .'</a></h2>';
                            echo '</td>';

                            echo '<td>';
                            echo '<h5 class="time-title p-0">Incident Category</h5>';
                            echo '<p>' . $incident_report['Incident_Category'] . '</p>';
                            echo '</td>';

                            echo '<td>';
                            echo '<h5 class="time-title p-0">Incident Category</h5>';
                            echo '<p>' . $incident_report['Incident_Category'] . '</p>';
                            echo '</td>';

                            echo '<td>';
                            echo '<h5 class="time-title p-0">Current Date</h5>';
                            echo '<p>' . $incident_report['SubmittedDate'] . '</p>';
                            echo '</td>';

                            echo '<td class="text-right">';
                            echo '<a href="report_details.php?report_id=' . $incident_report['ID'] . '" class="btn btn-outline-primary take-btn">View Details</a>';

                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<p class="no_review">No Reports available at the moment.</p>';
                    }
                    $stmt->close();
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
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>

      <!-- footer section -->
   <!-- <Footer class="info_section">
    <?php
    // require_once'Footer.php';
    ?>
  </Footer> -->
  <!-- footer section -->
</body>
</html>