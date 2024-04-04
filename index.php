<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
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

  <title>Blantyre Police Department</title>
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div class="hero_area">
    <div class="hero_bg_box">
      <div class="img-box">
      </div>
    </div>

    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
    <!-- slider section -->
    <section class=" slider_section ">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Your Saftey <br>
                      <span>
                        Our Responsibility
                      </span>
                    </h1>
                    <p>
                    We are pleased to introduce our Online Reporting System, designed to provide you with a 
                    convenient and efficient way to report incidents to the Blantyre Police Department. Whether 
                    you've witnessed a crime, experienced an incident, or have information to share, our platform is here to assist you.
                    </p>
                    <div class="btn-box">
                      <?php
                      if (isset($_SESSION['user_id'])) {
                          echo '<a href="Report_Form.php" class="btn-1">Fill in Police Report</a>';
                      } else {
                          echo '<a href="login.php" class="btn-1">Fill in Police Report</a>';
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container idicator_container">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          </ol>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>
  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6 px-0">
          <div class="img_container">
            <div class="img-box">
              <img src="images/about-img.jpg" alt="" />
            </div>
          </div>
        </div>
        <div class="col-md-6 px-0">
          <div class="detail-box">
            <div class="heading_container ">
              <h2>
                Who Are We?
              </h2>
            </div>
            <p>
            Welcome to the Blantyre Police Station! We are a dedicated team 
              of law enforcement professionals committed to serving and protecting 
              the community of Blantyre. With a rich history dating back decades, 
              we have been steadfast in our mission to uphold law and order, promote 
              public safety, and foster trust and cooperation within our community.
            </p>
            <div class="btn-box">
              <a href="about.php">
                Read More
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- footer section -->
   <Footer class="info_section">
    <?php
    require_once 'Footer.php';
    ?>
  </Footer>
  <!-- footer section -->

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>