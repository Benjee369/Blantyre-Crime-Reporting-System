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
        <!-- end side bar thing -->
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div id="reportContainer" class="report_form1">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title d-inline-block">Report Details</h4>
                                <button id="printReport" class="btn btn-primary float-right">Print/Save Report</button>
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
                    <div class="">
                        <div class="card member-panel">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">Multimedia Attachments</h4>
							</div>
                            <div class="card-body1">
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
                        <div class="card member-panel1">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">Incident Location</h4>
							</div>
                            <?php
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