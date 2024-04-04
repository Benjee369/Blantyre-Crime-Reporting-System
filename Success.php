<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

require_once 'DatabaseConn.php';

try {
    // Retrieve the report ID from the query parameters
    $report_id = filter_var($_GET['report_id'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the report ID is valid
    if (!$report_id) {
        throw new Exception("Invalid report ID provided.");
    }

    // Update the database to mark the assignment as paid
    $query = "UPDATE assignments SET Paid = 1 WHERE ReportID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo "Payment successful. Assignment marked as paid.";
    } else {
        echo "Error: Failed to update assignment.";
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // Handle errors (e.g., display an error message to the user)
    echo "Error: " . $e->getMessage();
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>

    <main class="success_init">
        <div class="main_success">
            <h1>Payment Successful!</h1>
            <p>Thank you for your payment. Your assignment has been marked as paid.</p>
        </div>
    </main>

    <Footer class="info_section">
    <?php
    require_once 'Footer.php';
    ?>
    </Footer>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
