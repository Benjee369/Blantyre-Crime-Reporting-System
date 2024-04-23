<!-- <div class="header_top">
        <div class="container-fluid">
          <div class="contact_link-container">
            <a href="" class="contact_link1">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <span>
                Lorem ipsum dolor sit amet,
              </span>
            </a>
            <a href="" class="contact_link2">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span>
                Call : +01 1234567890
              </span>
            </a>
            <a href="" class="contact_link3">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>
                demo@gmail.com
              </span>
            </a>
          </div>
        </div>
      </div> -->
      <div class="header_bottom">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container">
            <a class="navbar-brand" href="index.php">
              <span>
                Blantyre Police Station
              </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class=""></span>
            </button>

            <div class="collapse navbar-collapse ml-auto" id="navbarSupportedContent">
              <ul class="navbar-nav  ">
              <?php
                // Check if a general user is logged in
                if (isset($_SESSION['user_id'])) {
                    // If a user is logged in, display the logout button and all other navigation items
                    echo '<li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="officers.php">Officers</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact us</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Report_History.php">Report History</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Help.php">Help</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Logout.php">Logout</a>
                          </li>';
                } elseif (isset($_SESSION['admin_id']) || isset($_SESSION['officer_id'])) {
                    // If an admin or officer is logged in, only display the logout button
                    echo '<li class="nav-item">
                            <a class="nav-link" href="Logout.php">Logout</a>
                          </li>';
                } else {
                    // If no user, admin, or officer is logged in, display login and create account options
                    echo '<li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="officers.php">Officers</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact us</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Help.php">Help</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Login.php">Login</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Create_Account.php">Create Account</a>
                          </li>';
                }
                ?>
             
                <!-- <li class="nav-item">
                  <a class="nav-link" href="Admin_Side.php">Admin Side</a>
                </li>                 -->
              </ul>
            </div>
          </nav>
        </div>
      </div>