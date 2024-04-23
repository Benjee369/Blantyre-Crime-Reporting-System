<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once 'DatabaseConn.php';

if (!isset($_SESSION["isloggedin"])) {
  header("Location: Login.php");
  exit();
}

$sent_success = $sent_fail = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {  
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    $query = "INSERT INTO contact_us (Full_Name, Email, Phone_Number, Description, Date) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $fullname, $email, $phone, $message);  
    if ($stmt->execute()) {
        $sent_success = "Your Message has been received";
    } else {
        $sent_fail = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Contact Us</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <div class="hero_bg_box">
      <div class="img-box">
        <img src="images/hero-bg.jpg" alt="">
      </div>
    </div>
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>  
    </header>
    <!-- end header section -->
  </div>

  <!-- contact section -->

  <section class="contact_section layout_padding">
    <div class="contact_bg_box">
      <div class="img-box">
        <img src="images/contact-bg.jpg" alt="">
      </div>
    </div>
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Get In touch
        </h2>
      </div>
      <div class="">
        <div class="row">
          <div class="col-md-7 mx-auto">
            <form action="" method="POST">
              <div class="contact_form-container">
                <div>
                  <?php
                    if (isset($sent_success)) {
                        echo '<p class="pass">' . $sent_success . '</p>';
                    }
                    if (isset($sent_fail)) {
                        echo '<p class="wrong_details">' . $sent_fail . '</p>';
                    }
                  ?>
                  <div class="report_detail1">
                    <input type="text" placeholder="Full Name" name="fullname"/>
                  </div>
                  <div class="report_detail1">
                    <input type="email" placeholder="Email " name="email"/>
                  </div>
                  <div class="report_detail1">
                    <input type="text" placeholder="Phone Number" name="phone"/>
                  </div>
                  <div  class="report_detail1">
                    <input type="text" placeholder="Message" class="message_input" name="message"/>
                  </div>
                  <div class="btn-box ">
                  <input class="contact_us_btn" type="submit" value="Submit" />
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->
  <!-- footer section -->
  <footer class="info_section">
  <?php
    require_once'Footer.php';
    ?>
  </footer>
  <!-- footer section -->

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>