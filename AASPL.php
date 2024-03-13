<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    require_once 'DatabaseConn.php';

    // Retrieve values from the form
    $report_id = $_POST['report_id'];
    $officer_id = $_POST['officer_id'];
    $priority_level = $_POST['priority_level'];

    // Prepare and execute the SQL query to insert into the assignments table
    $query = "INSERT INTO assignments (ReportID, OfficerID, PriorityLevel) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $report_id, $officer_id, $priority_level);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Assignment successfully created.";
    } else {
        echo "Error creating assignment: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the report details page if the form was not submitted
    header("Location: report_details.php?report_id=$report_id");
    exit();
}
?>
