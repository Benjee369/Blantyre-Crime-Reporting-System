<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'DatabaseConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email_Address = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Perform authentication based on role
    if ($role == "admin") {
        $stmt = $conn->prepare("SELECT ID, Password FROM admindetails WHERE Email=? AND Role='admin'");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $Email_Address);
        $stmt->execute();
        $stmt->bind_result($userId, $storedHashedPassword);
        $stmt->fetch();
        
        if ($stmt->errno) {
            die("Execute error: " . $stmt->error);
        }
        
        if ($storedHashedPassword !== null && password_verify($password, $storedHashedPassword)) {
            $_SESSION["admin_id"] = $userId;
            $_SESSION["isloggedin"] = true;
            $_SESSION["invalidCredentials"] = false;
            header("Location: Admin_Side.php");
            exit();
        } else {
            if (!isset($_SESSION["login_attempts"])) {
                $_SESSION["login_attempts"] = 1;
            } else {
                $_SESSION["login_attempts"]++;
            }
        
            if ($_SESSION["login_attempts"] > 2) {
                $_SESSION["locked"] = time();
                header("Location: Admin-Login.php");
                exit();
            }
            $_SESSION['login_error_message'] = "Login failed. Please try again.";
        
            header("Location: Admin-Login.php");
            exit();
        }
    
    } elseif ($role == "officer") {
        $stmt1 = $conn->prepare("SELECT ID, Password FROM admindetails WHERE Email=? AND Role='officer'");
        if (!$stmt1) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt1->bind_param("s", $Email_Address);
        $stmt1->execute();
        $stmt1->bind_result($userId, $storedHashedPassword);
        $stmt1->fetch();
        
        if ($stmt1->errno) {
            die("Execute error: " . $stmt1->error);
        }
        if ($storedHashedPassword !== null && password_verify($password, $storedHashedPassword)) {
            // Fetch the officer ID from the database based on the email address
            $query = "SELECT ID FROM admindetails WHERE Email=? AND Role='officer'";
            $stmt1->close(); // Close the previous statement ($stmt1)
            $stmt2 = $conn->prepare($query);
            $stmt2->bind_param("s", $Email_Address);
            $stmt2->execute();
            $stmt2->bind_result($officerId);
            $stmt2->fetch(); // Fetch the result
            $stmt2->close(); // Close the statement
        
            // Set the officer ID in the session variable
            $_SESSION['officer_id'] = $officerId;
        
            $_SESSION["isloggedin"] = true;
            $_SESSION["invalidCredentials"] = false;
            // Redirect to the officer's dashboard
            header("Location: Officer_Side.php");
            exit();
        } else {
    
            if (!isset($_SESSION["login_attempts"])) {
                $_SESSION["login_attempts"] = 1;
            } else {
                $_SESSION["login_attempts"]++;
            }
        
            if ($_SESSION["login_attempts"] > 2) {
                $_SESSION["locked"] = time();
                header("Location: Admin-Login.php");
                exit();
            }
            $_SESSION['login_error_message'] = "Login failed. Please try again.";
            
            header("Location: Admin-Login.php");
            exit();
        }
    } else {
        echo "Invalid role selected.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Report Form</title>
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
    <main class="Test">
    <div class="parent clearfix">   
    <div class="login">
      <div class="container">
        <h1>Login to access to<br />your account</h1>
    
        <div class="login-form">
          <form action="" method="POST">
            <?php
              if (isset($_SESSION['login_error_message'])) {
                echo "<p class='wrong_details'>" . $_SESSION['login_error_message'] . "</p>";
                unset($_SESSION['login_error_message']);
              }           
            ?>
            <label for="role">Select Role:</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="officer">Officer</option>
            </select>
            <input type="email" name="email" placeholder="E-mail Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">LOG-IN</button>
            <p>Dont Have an Account? <a href="createadmin.php" >Create Account</a></p>
          </form>
        </div>    
      </div>
      </div>
    </div>
    </main>
    <footer class="info_section">
        <?php
        require_once 'Footer.php';
        ?>
    </footer>
    
</body>
</html>