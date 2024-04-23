<?php
require 'PHPMailer-master\src\PHPMailer.php';
require 'PHPMailer-master\src\SMTP.php';
require 'PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$UserID = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once 'DatabaseConn.php';

        //Code used to retrieve information from the user input boxes
        $FirstName = $_POST["firstname"] ?? null;
        $LastName = $_POST["lastname"] ?? null;
        $IncidentCategory = $_POST["incidentCategory"] ?? null;
        $CurrentDate = date("Y-m-d H:i:s");
        $WitnessedDate = $_POST["witnesseddate"] ?? null;
        $Description = $_POST["incidentDescription"] ?? null;
        $PeopleInvolved = $_POST["peopleInvolved"] ?? null;
        $IfAffected = isset($_POST["ifAffected"]) ? 1 : 0;
        $Location = $_POST["coordinates"] ?? null;

        //Code used to allow multiple media types on the form
        $Multimedia = "";
        if (isset($_FILES["file"])) {
            $fileTmpPath = $_FILES["file"]["tmp_name"];
            $fileName = $_FILES["file"]["name"];
            $uploadPath = "ReportMultimedia/" . $fileName;
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mp3', 'wav'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception("Invalid video type. Allowed types are jpg, jpeg, png, gif, mp4, avi, mp3, wav.");
            }
            if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
                throw new Exception("Failed to upload multimedia file.");
            }
            $Multimedia = $uploadPath;
        }
        
        //Code used to insert report detials into database
        $insertReportStmt = $conn->prepare("INSERT INTO crimereports (UserID, First_Name, Last_Name, Incident_Category, SubmittedDate, WitnessedDate, Description, People_Involved, If_Affected, Multimedia, Location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertReportStmt->bind_param("issssssiiss", $UserID, $FirstName, $LastName, $IncidentCategory, $CurrentDate, $WitnessedDate, $Description, $PeopleInvolved, $IfAffected, $Multimedia, $Location);

        if ($insertReportStmt->execute()) {
            $success_message = "Incident report successfully submitted.";
        } else {
            $error_message = "Error inserting incident report: " . $insertReportStmt->error;
        }

        //PHP mailer details
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'benjaminphiri369@gmail.com';
         $mail->Password = 'ortk mwod jnkf pbif';
         $mail->SMTPSecure = 'ssl';
         $mail->Port = 465;
        
         //Code used to send email to admin
         $mail->setFrom('johnbanda15243@gmail.com', 'Your Name');//This is the admin email
         $mail->addAddress('benjaminphiri369@gmail.com', 'Benjamin Phiri');
         $mail->Subject = 'New Police Report Submitted';
         $mail->Body = "A new police report has been submitted.\n\nFirst Name: $FirstName\nLast Name: $LastName\nIncident Category: $IncidentCategory\nWitnessed Date: $WitnessedDate\nDescription: $Description\nPeople Involved: $PeopleInvolved\nAffected: " . ($IfAffected ? 'Yes' : 'No') . "\nLocation: $Location";
 
         if ($mail->send()) {
             $success_message = "Incident report successfully submitted. The admin has been notified.";
         } else {
             $error_message = "Error sending email: " . $mail->ErrorInfo;
         }

        $insertReportStmt->close();
        $conn->close();

        //Notify user of invaid media format
    } catch (Exception $e) {
      $error_message = "Invalid video format.";
  }  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Report Form</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
    <header>
        <?php require_once 'nvbr.php'; ?>
    </header>
    <section class="report_page"> 
    <div class="report_form">
      <div class="container">
        <h1>Police Report Form</h1>
        
        <p>If you have witnessed an incident that falls under police attribution, please use this online police report form to signalize it.
             The police will review the report and take the appropriate action. Thank you for being a responsible citizen.
            <br><b>
              *Price of the Report Varies Depending on the Incident Category*
            </b></p>

            <!-- Used to notify user of successful or unsuccesful submission -->
        <?php
            if (isset($success_message)) {
                echo "<p class='success'>$success_message</p>";
            }
            if (isset($error_message)) {
                echo "<p class='wrong_details'>$error_message</p>";
            }
        ?>
          <div class="report-detail">

          <form action="" method="post" enctype="multipart/form-data">
            <hr>
            <div class="report_detail">
                <p class="report_form_label">Name of the person reporting the incident</p>
                <input type="text" placeholder="First" name="firstname">
                <input type="text" placeholder="Last" name="lastname">
            </div>
            <hr>
            <div class="report_detail">
              <p class="report_form_label">Select Incident Category</p>
            <select name="incidentCategory" class="incident_field">
                <option value="Traffic Accident">Traffic Accident</option>
                <option value="Missing Identity Card">Missing Identity Card</option>
                <option value="Theft">Theft</option>
                <option value="Assault">Assault</option>
                <option value="Vandalism">Vandalism</option>
                <option value="Fraud">Fraud</option>
                <option value="Missing Person">Missing Person</option>
            </select>
            </div>
            <hr>
            <div class="mixture">
              <div class="report_detai">
                  <p class="report_form_label">Date when you witnessed the incident</p>
                  <input type="Date" name="witnesseddate">
              </div>

              <div class="report_detai">
                <p class="report_form_label">Time of Incident</p>
                <input type="time" name="witnesstime">
              </div>
            </div>            
            <hr>
            <div class="report_detail">
              <p class="report_form_label">Please Describe the Incident</p>
              <textarea name="incidentDescription" required></textarea>
            </div>

            <div class="mixture">
                <div class="report_detai">
                  <p class="report_form_label">How many people were involved?</p>
                  <input type="number" name="peopleInvolved">
                </div>

                <div class="report_detai">
                  <p class="report_form_label">Were you in any way affected by the incident?</p>
                  <input type="radio" name="ifAffected" value="Yes">
                  <label for="html">Yes</label><br>
                  <input type="radio" name="ifAffected" value="No">
                  <label for="css">No</label><br>
                </div>
            </div>
            <hr>
            <div class="report_detail">
              <p class="report_form_label">Multimedia Attachment</p>
              <input type="file" id="image"  placeholder="Image" name="file" class="entry"  accept="image/*" required><br>
            </div> 
            <hr>
            <div id="map">

            </div>

            <!-- Coordinates input -->
            <label for="coordinates">Coordinates:</label>
            <input type="text" id="locationInput" name="coordinates" readonly>
            <input type="hidden" id="latitudeInput" name="latitude">
            <input type="hidden" id="longitudeInput" name="longitude">
            <br>

            <button type="submit">Submit Report</button>
          </form>
        </div>
    
      </div>
      </div>
    </section>
    <footer class="info_section">
        <?php require_once 'Footer.php'; ?>
    </footer>

    <!-- Code to show Location map on the report form -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-15.759612, 35.022580], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var locationInput = document.getElementById('locationInput');
        var latitudeInput = document.getElementById('latitudeInput');
        var longitudeInput = document.getElementById('longitudeInput');

        function onMapClick(e) {
            locationInput.value = e.latlng.lat.toFixed(6) + ', ' + e.latlng.lng.toFixed(6);
            latitudeInput.value = e.latlng.lat;
            longitudeInput.value = e.latlng.lng;
        }

        map.on('click', onMapClick);
    </script>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>
