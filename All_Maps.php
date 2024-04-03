<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

// Connect to the database (replace with your actual connection details)
$conn = new mysqli('localhost', 'root', '', 'crime_reporting_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$crimeData = [];

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT Location FROM crimereports");

// Execute the statement
if ($stmt->execute()) {
  // Bind the result to a variable
  $result = $stmt->get_result();

  // Fetch the results
  while ($row = $result->fetch_assoc()) {
    // Sanitize the location data
    $location = htmlspecialchars($row['Location']);

    // Check if the location string is empty
    if (empty($location)) {
        continue; // Skip this entry
    }

    // Check for comma separator and handle invalid formats
    if (strpos($location, ', ') === false) {
      echo "Invalid location format: " . $location . "<br>";
      continue; // Skip this entry
    }

    // Extract latitude and longitude (now with trimming)
    $parts = explode(',', $location);
    if (count($parts) !== 2) {
        echo "Invalid location format (missing value): " . $location . "<br>";
        continue; // Skip this entry
    }

    $latitude = trim($parts[0]);
    $longitude = trim($parts[1]);

    // Add the crime location data to the array
    $crimeData[] = array('latitude' => $latitude, 'longitude' => $longitude);
  }

  // Free the result set
  $result->free();
} else {
  // Handle the error if the query execution fails
  echo "Error executing the query: " . $stmt->error;
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close(); 
// echo "Number of crime locations found: " . count($crimeData) . "<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blantyre Police Department</title> 
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link href="css/responsive.css" rel="stylesheet" /><link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>
<body>
    <header class="header_section">
        <?php 
        require_once 'nvbr.php';
        ?>
    </header>
    <div class="main-wrapper">
        <?php 
        require_once 'officer_side_bar.php'; 
        ?>
        <div class="page-wrapper1">
            <div id="map" style="width: 99%; height: 530px;"></div>
            <script>
                // Initialize Leaflet map
                var map = L.map('map').setView([-15.759612, 35.022580], 12);

                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Add crime markers to the map
                <?php foreach ($crimeData as $crime) : ?>
                var latitude = <?= $crime['latitude'] ?>;
                var longitude = <?= $crime['longitude'] ?>;

                console.log("Latitude:", latitude, "Longitude:", longitude);

                var marker = L.marker([latitude, longitude]).addTo(map);
                // ... rest of marker code
                <?php endforeach; ?>
            </script>
        </div>
    </div>
</body>
</html>