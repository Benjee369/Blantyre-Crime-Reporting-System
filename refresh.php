<?php
// Connect to the database
require_once 'DatabaseConn.php';

// Get the report ID from the AJAX request
$report_id = $_GET['report_id'];

// Fetch the latest messages for the given report ID
$query = "SELECT * FROM chats WHERE report_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();
    
// Create an array to store the messages
$messages = array();

// Loop through the result set and add each message to the array
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

// Close the database connection
$stmt->close();
$conn->close();

// Return the messages as a JSON response
header('Content-Type: application/json');
echo json_encode($messages);
?>
