<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

require_once 'DatabaseConn.php';
require 'PHPMailer-master\src\PHPMailer.php';
require 'PHPMailer-master\src\SMTP.php';
require 'PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try {
    $report_id = filter_var($_GET['report_id'], FILTER_SANITIZE_NUMBER_INT);

    if (!$report_id) {
        throw new Exception("Invalid report ID provided.");
    }

    $query = "UPDATE assignments SET Paid = 1 WHERE ReportID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Retrieve user email address
        $user_query = "SELECT u.Email_Address 
                       FROM userdetails u 
                       INNER JOIN crimereports c ON u.ID = c.UserID 
                       WHERE c.ID = ?";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bind_param("i", $report_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();

        if ($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $user_email = $user_row['Email_Address'];

            // Send confirmation email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'benjaminphiri369@gmail.com';
            $mail->Password = 'ortk mwod jnkf pbif';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('benjaminphiri369@gmail.com', 'Benjamin Phiri');
            $mail->addAddress($user_email); // User email

            $mail->isHTML(true);
            $mail->Subject = 'Payment Confirmation';
            $mail->Body = 'Your payment for the assignment has been successful.';

            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Payment successful. Assignment marked as paid. Confirmation email sent.';
            }
        } else {
            echo "User email not found.";
        }
    } else {
        echo "Error: Failed to update assignment.";
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
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
    require_once 'nvbr.php'; 
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
