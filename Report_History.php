<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION["isloggedin"])) {
    header("Location: Login.php");
    exit();
}
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

                    $query = "SELECT c.*, u.First_Name AS User_First_Name, u.Last_Name AS User_Last_Name, a.Status, a.PaymentApproved, a.Paid, rp.Price
          FROM crimereports c
          INNER JOIN userdetails u ON u.ID = c.UserID
          LEFT JOIN assignments a ON c.ID = a.ReportID
          LEFT JOIN ReportPrice rp ON c.Incident_Category = rp.Category
          WHERE u.ID = ?
          ORDER BY c.SubmittedDate DESC";

                    
                
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $userId);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $incident_reports = $result->fetch_all(MYSQLI_ASSOC);
                    foreach ($incident_reports as $incident_report) {
                        echo '<tr>';
                        echo '<td style="min-width: 200px;">';
                        echo '<p><b>' . $incident_report['User_First_Name'] . ' ' . $incident_report['User_Last_Name'] . '</b></h2>';
                        echo '<p>Name on the Report: ' . $incident_report['First_Name'] . ' ' . $incident_report['Last_Name'] . '</p>';
                        echo '</td>';


                        // echo '<td>';
                        // echo '<h5 class="time-title p-0">Coordinates</h5>';
                        // echo '<p>' . $incident_report['Location'] . '</p>';
                        // echo '</td>';

                        echo '<td>';
                        echo '<h5 class="time-title p-0">Incident Category</h5>';
                        echo '<p>' . $incident_report['Incident_Category'] . '</p>';
                        echo '</td>';

                        echo '<td>';
                        echo '<h5 class="time-title p-0">Report Status</h5>';
                        echo '<p>' . $incident_report['Status'] . '</p>';
                        echo '</td>';

                        echo '<td>';
                        echo '<h5 class="time-title p-0">Submitted Date</h5>';
                        echo '<p>' . $incident_report['SubmittedDate'] . '</p>';
                        echo '</td>';

                        echo '<td>';
                        echo '<h5 class="time-title p-0">Price</h5>';
                        echo '<p> MWK ' . $incident_report['Price'] . '</p>';
                        echo '</td>';

                        echo '<td class="text-right">';
                        if ($incident_report['PaymentApproved'] == 1 && $incident_report['Paid'] == 0) {
                            echo '<a href="checkout.php?report_id=' . $incident_report['ID'] . '" class="btn btn-outline-primary take-btn">Pay Now</a>';
                        } elseif ($incident_report['Paid'] == 1) {
                            echo '<a href="print_report.php?report_id=' . $incident_report['ID'] . '" class="btn btn-outline-success take-btn">Print Report</a>';
                        } else {
                            echo '<button class="btn btn-outline-secondary take-btn" disabled>Payment Approval Pending</button>';                            echo '';
                        }
                        echo '</td>';

                        echo '<td class="text-right">';
                        echo '<a href="Chat_Interface.php?report_id=' . $incident_report['ID'] . '" class="btn btn-outline-primary take-btn">Chat with Officer</a>';
                        echo '</td>';

                        echo '</tr>';
                    }
                } else {
                    echo '<p class="no_review">No Reports Available at the moment</p>';
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
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>