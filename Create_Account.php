<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />    
    <title>Document</title>
</head>
<body>
    <header>
        <?php
        require_once 'nvbr.php';
        ?>
    </header>
    <main>
    <div class="parent clearfix">   
    <div class="login">
      <div class="container">
        <h1>Create an account to <br />easyily submit crime reports</h1>
        <?php
          if(isset($_SESSION['Email_address_taken'])){
            if($_SESSION['Email_address_taken']){
                echo "<p class='wrong_details'>This Email Address is already taken.<br> Please try a different Email Address</p>";
              }
            }
          if(isset($_SESSION['password_not_strong'])){
            if($_SESSION['password_not_strong']){
              echo "<p class='wrong_details'>Password must be at least 6 characters long and contain both numbers and letters.</p>";
            }
          }
        ?>
        <div class="login-form">
          <form action="Add_account.php" method="POST">
            <input type="text" name="userfirstname" placeholder="First Name" required>
            <input type="text" name="userlastname" placeholder="Last Name" required>
            <input type="email" name="useremail" placeholder="E-mail Address" required>
            <input type="text" name="usernumber" placeholder="Phone Number" required>
            <input type="text" name="useraddress" placeholder="local Address" >
            <input type="password" name="userpassword" placeholder="Password" required>
            <button type="submit">Create Account</button>
            <hr class="line-thing2">
            <p>Already Have an Account? <a class="create_log_btn">Login</a></p>
          </form>
        </div>
      </div>
      </div>
  </div>
</main>
    <footer>
        <?php
        require_once 'Footer.php';
        ?>
    </footer>
</body>
</html>