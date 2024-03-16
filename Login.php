<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['login_failed'])) {
  $_SESSION['login_failed'] = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Login</title>
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
          <form action="Login_user.php" method="POST">
            <?php
              if (isset($_SESSION['login_error_message'])) {
                echo "<p class='wrong_details'>" . $_SESSION['login_error_message'] . "</p>";
                unset($_SESSION['login_error_message']);
              }           
            ?>
            <input type="email" name="useremail" placeholder="E-mail Address" required>
            <input type="password" name="userpassword" placeholder="Password" required>
            <button type="submit">Log In</button>
            <p>Dont have an Account?  <a href="Create_Account.php" class="create_log_btn">Create Account</a></p>
          </form>
        </div>    
      </div>
      </div>
    </div>
    <div class="admin-login">
      <a href="Admin-Login.php">Login as Admin or Police Officer</a>
    </div>
    </main>
    <footer class="info_section">
        <?php
        require_once 'Footer.php';
        ?>
    </footer>
    
</body>
</html>