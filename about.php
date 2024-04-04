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

  <title>Guarder</title>

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
            <p>Welcome to the Blantyre Police Station! We are a dedicated team 
              of law enforcement professionals committed to serving and protecting 
              the community of Blantyre. With a rich history dating back decades, 
              we have been steadfast in our mission to uphold law and order, promote 
              public safety, and foster trust and cooperation within our community.
              <br><br>
              At Blantyre Police Station, we believe in the core values of integrity, 
              professionalism, and compassion. Our officers are trained to handle a 
              wide range of situations with diligence, fairness, and respect for all
               individuals. Whether responding to emergencies, conducting investigations,
                or engaging with community members, our goal is to ensure the safety
                 and well-being of every resident in Blantyre.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->


  <!-- footer section -->
  <Footer class="info_section">
    <?php
    require_once'Footer.php';
    ?>
  </Footer>
  <!-- footer section -->

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>