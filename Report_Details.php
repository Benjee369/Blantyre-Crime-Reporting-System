<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION["isloggedin"])) {
    header("Location: Admin-Login.php");
    exit();
}
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
    <link href="css/responsive.css" rel="stylesheet" /><link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
                            <div class="card-body1">
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
                                        echo '<div class="report_info_mix">';
                                        echo '<div class="report_info">';
                                        echo '<h2> User Details'.'</h2>';
                                        echo '</div>';

                                        echo '<div class="report_info">';
                                        echo '<p>Report ID: ' . $report_details['ID'] . '</p>';
                                        echo '</div>';
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
                            </div>
                        </div>
                        <!--Where the report_details controls go-->
                        <div class="report_controls">
                            <?php
                            if(isset($_SESSION['officer_id'])){
                            ?>
                            <?php
                            //Code to approve payment of a report
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    require_once 'DatabaseConn.php';
                                    $report_id = isset($_POST['report_id']) ? $_POST['report_id'] : null;

                                    if (isset($_POST['approve_payment'])) {
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

                                    // Check if the update status form was submitted
                                    if (isset($_POST['update_status'])) {
                                        $status = isset($_POST['status']) ? $_POST['status'] : null;

                                        //Update status of report
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

                                <!-- Your HTML code -->
                                <div class="mixture3">
                                    <div class="initialise_chat">
                                        <a class="btn btn-primary" href="Chat_Interface.php?report_id=<?php echo $report_id; ?>">Initialize Chat</a>
                                    </div>
                                    <div class="approve_payment">
                                        <form method="post">
                                            <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                                            <input type="hidden" name="approve_payment" value="1">
                                            <input type="submit" class="btn btn-primary float-right" value="Approve for Payment">
                                        </form>
                                    </div>
                                </div>

                                <div class="update_status">
                                    <form method="post">
                                        <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                                        <input type="hidden" name="update_status" value="1">
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
                                <!-- Show only when admin is logged in -->
                                <?php
                                } elseif(isset($_SESSION['admin_id'])){
                                ?>
                                <form action="AASPL.php" method="post">
                                    <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                                    <label for="officer_id">Assign to Officer:</label>
                                    <select name="officer_id" required>
                                        <option value="">Select Officer</option>
                                        <?php
                                        //Select all oficers in the system and display them in combo box
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

                                    <!-- Display all the priority levels in a combo box -->
                                    <label for="priority_level">Priority Level:</label>
                                    <select name="priority_level" required>
                                        <option value="">Select Priority Level</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                    <input class="btn btn-primary" type="submit" value="Assign and Set Priority">
                                </form> 
                                <?php
                                }
                                ?>
                        </div>
                    </div> 

                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card member-panel">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">Multimedia Attachments</h4>
							</div>
                            <div class="card-body">
                            <?php
                            //Code to select multimedia for the report and to display it
                                require_once 'DatabaseConn.php';

                                $report_id = isset($_GET['report_id']) ? $_GET['report_id'] : null;

                                $query = "SELECT * FROM crimereports WHERE ID = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $report_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $multimedia_path = $row['Multimedia'];
                                        $file_extension = strtolower(pathinfo($multimedia_path, PATHINFO_EXTENSION));

                                        switch ($file_extension) {
                                            case 'jpg':
                                            case 'jpeg':
                                            case 'png':
                                            case 'gif':
                                                echo '<img src="' . $multimedia_path . '" alt="Multimedia Attachment" class="img-fluid">';
                                                break;
                                            case 'mp4':
                                            case 'mov':
                                            case 'avi':
                                                echo '<video controls><source src="' . $multimedia_path . '" type="video/mp4"></video>';
                                                break;
                                            case 'mp3':
                                            case 'wav':
                                                echo '<audio controls><source src="' . $multimedia_path . '" type="audio/mpeg"></audio>';
                                                break;
                                            default:
                                                echo '<p>Unsupported multimedia file type.</p>';
                                                break;
                                        }
                                    }
                                } else {
                                    echo '<p>No multimedia attachments found for this report.</p>';
                                }

                                $stmt->close();
                                $conn->close();
                            ?>
                            </div>
                        </div>
                        <div class="card member-panel">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">Incident Location</h4>
							</div>
                            <?php
                            //Select coordinates for specific report and display them on a map
                            $conn = new mysqli('localhost', 'root', '', 'crime_reporting_system');

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $crimeData = [];

                            $report_id = isset($_GET['report_id']) ? $_GET['report_id'] : null;

                            $stmt = $conn->prepare("SELECT Location FROM crimereports WHERE ID = ?");
                            $stmt->bind_param("i", $report_id);
                            $stmt->execute();
                            if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {

                                $location = htmlspecialchars($row['Location']);
                                if (empty($location)) {
                                    continue;
                                }
                                if (strpos($location, ', ') === false) {
                                echo "Invalid location format: " . $location . "<br>";
                                continue;
                                }
                                $parts = explode(',', $location);
                                if (count($parts) !== 2) {
                                    echo "Invalid location format (missing value): " . $location . "<br>";
                                    continue;
                                }
                                $latitude = trim($parts[0]);
                                $longitude = trim($parts[1]);
                                $crimeData[] = array('latitude' => $latitude, 'longitude' => $longitude);
                            }

                            $result->free();
                            } else {
                            echo "Error executing the query: " . $stmt->error;
                            }
                            $stmt->close();
                            $conn->close(); 
                            ?>
                            <div class="card-body">
                                <div id="map" style="width: 100%; height: 275px;"></div>
                                <script>
                                    var map = L.map('map').setView([-15.759612, 35.022580], 11);

                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                    }).addTo(map);

                                    <?php foreach ($crimeData as $crime) : ?>
                                    var latitude = <?= $crime['latitude'] ?>;
                                    var longitude = <?= $crime['longitude'] ?>;

                                    console.log("Latitude:", latitude, "Longitude:", longitude);

                                    var marker = L.marker([latitude, longitude]).addTo(map);
                                    <?php endforeach; ?>
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
</body>
</html>