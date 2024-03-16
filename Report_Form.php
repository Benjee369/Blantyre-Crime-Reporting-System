<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$UserID = $_SESSION["user_id"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Include the database connection file
        require_once 'DatabaseConn.php';

        // Extract report details from the form
        $FirstName = $_POST["firstname"] ?? null;
        $LastName = $_POST["lastname"] ?? null;
        $IncidentCategory = $_POST["incidentCategory"] ?? null;
        $CurrentDate = date("Y-m-d H:i:s");
        $WitnessedDate = $_POST["witnesseddate"] ?? null;
        $Description = $_POST["incidentDescription"] ?? null;
        $PeopleInvolved = $_POST["peopleInvolved"] ?? null;
        $IfAffected = isset($_POST["ifAffected"]) ? 1 : 0;
        $Location = $_POST["coordinates"] ?? null;

        // Handle multimedia attachment
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

        // Insert report details into the database
        $insertReportStmt = $conn->prepare("INSERT INTO crimereports (UserID, First_Name, Last_Name, Incident_Category, CurrentDate, WitnessedDate, Description, People_Involved, If_Affected, Multimedia, Location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertReportStmt->bind_param("issssssiiss", $UserID, $FirstName, $LastName, $IncidentCategory, $CurrentDate, $WitnessedDate, $Description, $PeopleInvolved, $IfAffected, $Multimedia, $Location);

        if ($insertReportStmt->execute()) {
            $success_message = "Incident report successfully submitted.";
        } else {
            $error_message = "Error inserting incident report: " . $insertReportStmt->error;
        }

        $insertReportStmt->close();
        $conn->close();
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
             The police will review the report and take the appropriate action. Thank you for being a responsible citizen.</p>
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
            <input type="text" id="coordinates" name="coordinates" readonly>
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
    
  <script src="js/mapAPI.js" defer></script>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>
