<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    require_once 'DatabaseConn.php';

    // Extract user details from the form
    $FirstName = $_POST["userfirstname"];
    $LastName = $_POST["userlastname"];
    $Email = $_POST["useremail"];
    $PhoneNumber = $_POST["usernumber"];
    $Address = $_POST["useraddress"];
    $Password = $_POST["userpassword"];

    // // Check if the password meets the requirements
    // if (strlen($Password) < 6 || !preg_match('/[0-9]/', $Password) || !preg_match('/[a-zA-Z]/', $Password)) {
    //     $_SESSION['password_not_strong'] = true;
    //     header("Location: Create_Account.php");
    //     exit();
    // }

    // Check if the email is already taken
    $checkStmt = $conn->prepare("SELECT ID FROM userdetails WHERE Email_Address = ?");
    $checkStmt->bind_param("s", $Email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows > 0) {
        $_SESSION['Email_address_taken'] = true;
        header("Location: Create_Account.php");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Insert user details into the database
    $insertStmt = $conn->prepare("INSERT INTO userdetails (First_Name, Last_Name, Email_Address, Phone_Number, Address, Password) VALUES (?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("ssssss", $FirstName, $LastName, $Email, $PhoneNumber, $Address, $hashedPassword);

    if ($insertStmt->execute()) {
        $success_message = "You have successfully registered. <a href='Login.php'>Login</a>";
    } else {
        $error_message = "Error: " . $insertStmt->error;
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link href="css/main-style.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
</head>
<body>
<header>
    <?php require_once 'nvbr.php'; ?>
</header>
<main>
    <div class="parent clearfix">   
        <div class="login">
            <div class="container">
                <h1>Create an account to <br />easily submit crime reports</h1>
                <?php
                if(isset($_SESSION['Email_address_taken']) && $_SESSION['Email_address_taken']) {
                    echo "<p class='wrong_details'>This Email Address is already taken. Please try a different Email Address</p>";
                }
                if(isset($_SESSION['password_not_strong']) && $_SESSION['password_not_strong']) {
                    echo "<p class='wrong_details'>Password must be at least 6 characters long and contain both numbers and letters.</p>";
                }
                if(isset($success_message)) {
                    echo "<p class='success'>$success_message</p>";
                }
                if(isset($error_message)) {
                    echo "<p class='error'>$error_message</p>";
                }
                ?>
                <div class="login-form">
                    <form action="" method="POST">
                        <input type="text" name="userfirstname" placeholder="First Name" required>
                        <input type="text" name="userlastname" placeholder="Last Name" required>
                        <input type="email" name="useremail" placeholder="E-mail Address" required>
                        <input type="text" name="usernumber" placeholder="Phone Number" required>
                        <input type="text" name="useraddress" placeholder="local Address">
                        <input type="password" name="userpassword" placeholder="Password" required>
                        <button type="submit">Create Account</button>
                        <hr class="line-thing2">
                        <p>Already Have an Account? <a href="Login.php" class="create_log_btn">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="info_section">
    <?php require_once 'Footer.php'; ?>
</footer>
</body>
</html>
