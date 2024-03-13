<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
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
    
        $FirstName = $_POST["userfirstname"];
        $LastName = $_POST["userlastname"];
        $Email = $_POST["useremail"];
        $PhoneNumber = $_POST["usernumber"];
        $Address = $_POST["useraddress"];
        $Password = $_POST["userpassword"];
        // if (strlen($Password) < 6 || !preg_match('/[0-9]/', $Password) || !preg_match('/[a-zA-Z]/', $Password)) {
        //     $_SESSION['password_not_strong'] = true;
        //     header("Location: Create_Account.php");
        //     exit();
        // }
        $checkStmt = $conn->prepare("SELECT ID, Email_Address FROM userdetails WHERE Email_Address = ?");
        $checkStmt->bind_param("s", $Email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            $_SESSION['Email_address_taken'] = true;
            header("Location: Create_Account.php");
            exit();
        } else {
            $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
            $insertStmt = $conn->prepare("INSERT INTO userdetails (First_Name, Last_Name, Email_Address,Phone_NUmber, Address, Password) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("ssssss", $FirstName, $LastName, $Email, $PhoneNumber, $Address, $hashedPassword);
        
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
