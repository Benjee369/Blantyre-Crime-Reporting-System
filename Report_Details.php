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
    <?php
        if (isset($_SESSION['officer_id'])) {
            require_once 'officer_side_bar.php';
        } else {
            require_once 'side-bar.php';
        }
    ?>
        <!-- end side bar thing -->
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="report_form1">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title d-inline-block">Report Details</h4>
                                <a href="View_Reports.php" class="btn btn-primary float-right">View all</a>
                            </div>
                            <div class="card-body -0">
                                <?php
                                    require_once 'DatabaseConn.php';
                                    
                                    $report_id = isset($_GET['report_id']) ? $_GET['report_id'] : null;

                                    $query = "SELECT c.*, u.Address, u.Email_Address FROM crimereports c, userdetails u WHERE u.ID = c.UserID AND c.ID = ?";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("i", $report_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $report_details = $result->fetch_assoc();
                                        echo '<div class="report_info">';
                                        echo '<h2> User Details'.'</h2>';
                                        echo '</div>';

                                        // echo ''.$report_id.'';
                                        echo '<div class="report_info_mix">';
                                        echo '<div class="report_info2">';
                                        echo '<p>Full Name: ' . $report_details['First_Name'] . ' ' . $report_details['Last_Name'] . '</p>';
                                        echo '</div>';

                                        echo '<div class="report_info2">';
                                        echo '<p>Email: ' . $report_details['Email_Address'] . '</p>';
                                        echo '</div>';
                                        echo '</div>';

                                        echo '<div class="report_info">';
                                        echo '<p>Address: '. $report_details['Address'] .'</p>';
                                        echo '</div>';

                                        echo '<div>';
                                        echo '<h2 class="report_info"> Incident Details'.'</h2>';
                                        echo '</div>';

                                        echo '<div class="report_info_mix">';
                                        echo '<div class="report_info">';
                                        echo '<p>Date: ' . $report_details['WitnessedDate'] . '</p>';
                                        echo '</div>';
                                        
                                        echo '<div class="report_info">';
                                        echo '<p>location: ' . $report_details['Location'] . '</p>';
                                        echo '</div>';
                                        echo '</div>';

                                        echo '<div class="report_info">';
                                        echo '<p>Incident Category: ' . $report_details['Incident_Category'] . '</p>';    
                                        echo '</div>';
                                    
                                        echo '<div class="report_info_mix">';
                                        echo '<div class="report_info2">';
                                        echo '<p>Number Of People Involved: ' . $report_details['People_Involved'] . '</p>';
                                        echo '</div>';

                                        echo '<div class="report_info">';
                                        echo '<p>Were you affected?: '. $report_details['If_Affected'] .'</p>';
                                        echo '</div>';
                                        echo '</div>';

                                        echo '<div class="report_info">';
                                        echo '<p>Description: ' . $report_details['Description'] . '</p>';
                                        echo '</div>';
                                        
                                    } else {
                                        echo '<p>Report not found</p>';
                                    }

                                    $stmt->close();
                                ?> 
                                    <br>
                                    <br>
                                    <div class="mixture3">
                                        <?php
                                            // Assuming $report_id is available in your code (e.g., from the report details page)

                                            if (isset($_SESSION['officer_id'])) {
                                            ?>
                                            <div class="initialise_chat">
                                                <a class="btn btn-primary" href="Chat_Interface.php?report_id=<?php echo $report_id; ?>">Initialize Chat</a>
                                            </div>
                                            <?php
                                            } else {
                                                // ... button or message for users who can't initiate chats
                                            }
                                        ?>
                                        
                                        <?php
                                            if (isset($_SESSION['officer_id'])) {
                                        ?>
                                        <div class="approve_payment">
                                            <form method="post">
                                                <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                                                <input type="submit" class="btn btn-primary float-right" value="Approve for Payment">
                                            </form>
                                        </div>                                                
                                    </div>   
                                    <?php
                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                require_once 'DatabaseConn.php';
                                                $report_id = isset($_POST['report_id']) ? $_POST['report_id'] : null;

                                                if ($report_id !== null) {
                                                    $query = "UPDATE assignments SET paymentapproved = 1 WHERE reportID = ?";
                                                    $stmt = $conn->prepare($query);
                                                    $stmt->bind_param("i", $report_id);
                                                    $stmt->execute();

                                                    if ($stmt->affected_rows > 0) {
                                                        echo "Payment approved successfully.";
                                                    } else {
                                                        echo '<p class="wrong_detai">Payment has already been approved</p>';
                                                    }
                                                    $stmt->close();
                                                } else {
                                                    echo "Error: Report ID not provided.";
                                                }
                                            }
                                        }
                                    ?>
                            </div>
                        </div>  
                    <?php
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

                            }
                        ?>
                        <?php
                            if (isset($_SESSION['officer_id'])) {
                        ?>
                                <div class="update_status">
                                    <form method="post">
                                        <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                                        <label for="status">Update Status of Report:</label>
                                        <select name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="On Hold">On Hold</option>
                                            <option value="Closed">Closed</option>
                                            <option value="Reopened">Reopened</option>
                                        </select>
                                        <input class="btn btn-primary float-right" type="submit" value="Update Status">
                                    </form>
                                </div>
                            <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                    require_once 'DatabaseConn.php';

                                    $report_id = isset($_POST['report_id']) ? $_POST['report_id'] : null;
                                    $status = isset($_POST['status']) ? $_POST['status'] : null;

                                    if ($report_id !== null && $status !== null) {

                                        $query = "UPDATE assignments SET Status = ? WHERE ReportID = ?";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("si", $status, $report_id);
                                        $stmt->execute();

                                        if ($stmt->affected_rows > 0) {
                                            echo "Status successfully updated.";
                                        } else {
                                            echo "Error updating status: " . $stmt->error;
                                        }

                                        $stmt->close();
                                    } else {
                                        echo "";
                                    }
                                }
                                }
                            ?>
                        </div>         
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card member-panel">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">Multimedia Attachments</h4>
							</div>
                            <div class="card-body">
                                <?php
                                require_once 'DatabaseConn.php';

                                $report_id = isset($_GET['report_id']) ? $_GET['report_id'] : null;

                                $query = "SELECT * FROM crimereports WHERE ID = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $report_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<img src="' . $row['Multimedia'] . '" alt="Multimedia Attachment" class="img-fluid">';
                                    }
                                } else {
                                    echo '<p>No multimedia attachments found for this report.</p>';
                                }

                                $stmt->close();
                                $conn->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
</body>
</html>