<?php
// Enable error reporting for development (remove for production)
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_POST['report_id'])) {
  $report_id = $_POST['report_id'];
  $user_id = $_SESSION['user_id']; // Assuming you have a user session variable

  // Connect to the database
  require_once 'DatabaseConn.php';

  // Check if a chat already exists for this report
  $query = "SELECT id FROM chats WHERE report_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $report_id);
  $stmt->execute();
  $result = $stmt->get_result();

  // If chat doesn't exist, create a new entry with sender_type
  if ($result->num_rows === 0) {
    $sender_type = (isset($_SESSION['officer_id'])) ? 'officer' : 'user';

    $query = "INSERT INTO chats (report_id, user_id, officer_id, sender_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // **Fix for nullish coalescing operator error:**
    $officer_id = isset($_SESSION['officer_id']) ? $_SESSION['officer_id'] : null; // Assign null if officer_id not set

    $stmt->bind_param("iiii", $report_id, $user_id, $officer_id, $sender_type);
    $stmt->execute();
    $stmt->close();
  } else {
    // Handle the case where a chat already exists (optional)
  }

  // Redirect user to the chat interface (Chat_Interface.php)
  header("Location: Chat_Interface.php?report_id=$report_id");
  exit();
}
?>
