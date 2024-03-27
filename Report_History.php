<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Blantyre Police Department</title>
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
    <main class="history" >
        <h2>Report History</h2>
        <div class="">
        <div class="row">
					<div class="main-card-thing">
						<div class="card">
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table mb-0">
										<tbody>
                                        <?php
                        $userId = $_SESSION['user_id'];

                        require_once 'DatabaseConn.php';

                        $query = "SELECT c.*, u.*
                    FROM crimereports c, userdetails u
                    WHERE u.ID = ?
                    ORDER BY c.CurrentDate desc";
                    

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $incident_reports = $result->fetch_all(MYSQLI_ASSOC);
                        foreach ($incident_reports as $incident_report) {
                            echo '<tr>';
                            echo '<td style="min-width: 200px;">';
                            echo '<h2>' . $incident_report['First_Name'] . ' ' . $incident_report['Last_Name'] . '<span>' . $incident_report['Location'] . '</span></h2>';
                            echo '</td>';

                            echo '<td>';
                            echo '<h5 class="time-title p-0">Incident Category</h5>';
                            echo '<p>' . $incident_report['Incident_Category'] . '</p>';
                            echo '</td>';

                            echo '<td>';
                            echo '<h5 class="time-title p-0">Current Date</h5>';
                            echo '<p>' . $incident_report['CurrentDate'] . '</p>';
                            echo '</td>';

                            echo '<td class="text-right">';
                            echo '<a href="Chat_Interface.php?report_id=' . $incident_report['ID'] . '" class="btn btn-outline-primary take-btn">Chat with Officer</a>';

                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<p class="no_review">No Reviews available at the moment,<br>
                        Be the first To leave a Review.</p>';
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
    </main>
    <Footer class="info_section">
    <?php
    require_once 'Footer.php';
    ?>
  </Footer>
</body>
</html>