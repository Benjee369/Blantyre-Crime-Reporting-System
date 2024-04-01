<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

require_once 'DatabaseConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FirstName = $_POSt["firstname"];
    $LastName = $_POSt["lastname"];
    $Email = $_POST["useremail"];
    $Password = $_POST["userpassword"];
    $Role = $_POST["userrole"]; // Assuming the role is set in a dropdown/select menu

    $checkStmt = $conn->prepare("SELECT ID, Email FROM admindetails WHERE Email = ?");
    $checkStmt->bind_param("s", $Email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $_SESSION['Email_address_taken'] = true;
        header("Location: createadmin.php");
        exit();
    } else {
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
        $insertStmt = $conn->prepare("INSERT INTO admindetails (First_Name, Last_Name, Email, Password, Role) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssss", $FirstName, $LastName, $Email, $hashedPassword, $Role);

        if ($insertStmt->execute()) {
            echo "<div class='successfully_created'>
            <p>You have successfully registered</p>
            <a href='Login.php'><strong>Go to the login page</strong></a>
            </div>";
        } else {
            echo "Error: " . $insertStmt->error;
        }
    }

    $checkStmt->close();
    $insertStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <title>Add Officer or Admin</title>
</head>
<body>
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
        <!-- nav2 end -->
        <div class="page-wrapper">
             <div class="content">
        <!-- side bar thing -->
        <?php
        require_once 'side-bar.php';
        ?>
        <div class="parent clearfix">
            <div class="login">
                <div class="container">
                    <h1>Add a new Administrator or a Police Officer to the<br/>  System</h1>
                    <?php
                    if (isset($_SESSION['Email_address_taken']) && $_SESSION['Email_address_taken']) {
                        echo "<p class='wrong_details'>This Email Address is already taken.<br> Please try a different Email Address</p>";
                    }
                    ?>
                    <div class="login-form">
                        <form action="" method="POST">
                            <label for="userrole">Select Role:</label>
                            <select class="admin_role" name="userrole">
                                <option value="admin">Admin</option>
                                <option value="officer">Officer</option>
                            </select>
                            <input type="text" name="firstname" placeholder="First Name" required>
                            <input type="text" name="lastname" placeholder="Last Name" required>
                            <input type="email" name="useremail" placeholder="E-mail Address" required>
                            <input type="password" name="userpassword" placeholder="Password" required>
                            <button type="submit">Create Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
   
</body>
</html>
