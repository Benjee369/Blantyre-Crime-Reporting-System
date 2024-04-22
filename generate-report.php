<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crime_reporting_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data for all officers and count of reports assigned to each officer
$sql = "SELECT ad.ID AS OfficerID, ad.First_Name, ad.Last_Name, COUNT(a.AssignmentID) AS ReportCount
FROM admindetails AS ad
LEFT JOIN assignments AS a ON ad.ID = a.OfficerID
GROUP BY ad.ID
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $officers = array();

    // Fetch and format the data
    while ($row = mysqli_fetch_assoc($result)) {
        $officer = array(
            'OfficerID' => $row['OfficerID'],
            'First_Name' => $row['First_Name'],
            'Last_Name' => $row['Last_Name'],
            'ReportCount' => $row['ReportCount']
        );

        $officers[] = $officer;
    }

    // Prepare JSON response
    $response = array(
        'officers' => $officers
    );

    // Send JSON response
    echo json_encode($response);
} else {
    // Handle query error
    echo json_encode(array('error' => 'Failed to fetch officer data'));
}

// Close database connection
mysqli_close($conn);
?>
