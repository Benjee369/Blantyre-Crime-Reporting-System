<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$UserID = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header>
        <?php
        require_once 'nvbr.php';
        ?>
    </header>
    <main>
        <div class='row'>
            <?php
            require_once 'DatabaseConn.php';

            // Assuming the user is already logged in, you can retrieve user-related information from the session or wherever it's stored.
            $UserID = $_SESSION["user_id"]; // Change this to the actual session variable storing the user ID

            // Extract report details from the form
            $FirstName = $_POST["firstname"];
            $LastName = $_POST["lastname"];
            $IncidentCategory = $_POST["incidentCategory"];
            $CurrentDate = date("Y-m-d H:i:s"); // Current date and time
            $WitnessedDate = $_POST["witnesseddate"];
            $Description = $_POST["incidentDescription"];
            $PeopleInvolved = $_POST["peopleInvolved"];
            $IfAffected = isset($_POST["ifAffected"]) ? 1 : 0;
            $Location = $_POST["coordinates"];
// Handle multimedia attachment (you may need to modify this based on your actual form)
$Multimedia = ""; // Initialize to an empty string

// Echo to check if the file upload is triggered
echo "File Upload Triggered<br>";

// Check if the $_FILES array is set
if (isset($_FILES["file"])) {
    // Echo to check if the $_FILES array is set
    echo "FILES array is set<br>";

    $fileTmpPath = $_FILES["file"]["tmp_name"];
    $fileName = $_FILES["file"]["name"];

    // Echo to check if the file name is correct
    echo "File Name: " . $fileName . "<br>";

    // Destination path to store the uploaded file
    $uploadPath = "ReportMultimedia/" . $fileName;

    // Echo to check the upload path
    echo "Upload Path: " . $uploadPath . "<br>";

    // Array of allowed file types
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mp3', 'wav'];

    // Get the file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Echo to check if the file extension is correct
    echo "File Extension: " . $fileExtension . "<br>";

    // Check if the file extension is allowed
    if (in_array($fileExtension, $allowedExtensions)) {
        // Move the uploaded file to the destination path
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            // Set the multimedia variable to the file path
            $Multimedia = $uploadPath;

            // Echo to check if multimedia variable is set
            echo "Multimedia: " . $Multimedia . "<br>";
        } else {
            echo '<p class="fail">Failed to upload file.</p>';
        }
    } else {
        echo '<p class="fail">Invalid file type. Allowed types are jpg, jpeg, png, gif, mp4, avi, mp3, wav.</p>';
    }
} else {
    // Echo to check if the $_FILES array is not set
    echo "FILES array is not set<br>";
}

            // Handle location (you may need to modify this based on your actual form)
             // Replace this with the logic to handle the location

            // Insert report details into the incidentreports table
            $insertReportStmt = $conn->prepare("INSERT INTO crimereports (UserID, First_Name, Last_Name, Incident_Category, CurrentDate, WitnessedDate, Description, People_Involved, If_Affected, Multimedia, Location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die($conn->error);
            $insertReportStmt->bind_param("issssssiiss", $UserID, $FirstName, $LastName, $IncidentCategory, $CurrentDate, $WitnessedDate, $Description, $PeopleInvolved, $IfAffected, $Multimedia, $Location);

            // Execute the report insertion query
            if ($insertReportStmt->execute()) {
                echo "<div class='successfully_created'>
                    <p>Incident report successfully submitted</p>
                </div>";
            } else {
                echo "Error inserting incident report: " . $insertReportStmt->error;
            }

            $insertReportStmt->close();
            $conn->close();
            ?>
        </div>
    </main>
    <Footer>
        <?php
        require_once 'Footer.php';
        ?>
    </Footer>
</body>

</html>

