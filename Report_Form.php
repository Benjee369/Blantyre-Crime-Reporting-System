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
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <title>Report Form</title>
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
  
</head>
<body>
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
    <section class="report_page"> 
    <div class="report_form">
      <div class="container">
        <h1>Police Report Form</h1>
        <p>If you have witnessed an incident that files under police attribution, please use this online police report form to signalize it.
             The police will review the report and take the appropriate action. Thank you for being a responsible citizen.</p>
        <div class="report-detail">
          <form action="Submit_Report.php" method="post" enctype="multipart/form-data">
            <div class="report_detail">
                <p>Name of the person reporting the incident</p>
                <input type="text" placeholder="First" name="firstname">
                <input type="text" placeholder="Last" name="lastname">
            </div>
            <div class="report_detail">
              <p>Select Incident Category</p>
            <select name="incidentCategory" class="incident_field">
                <option value="Traffic Accident">Traffic Accident</option>
                <option value="Theft">Theft</option>
                <option value="Assault">Assault</option>
                <option value="Vandalism">Vandalism</option>
                <option value="Fraud">Fraud</option>
                <option value="Missing Person">Missing Person</option>
            </select>
            </div>
            <div class="mixture">
              <div class="report_detai">
                  <p>Date when you witnessed the incident</p>
                  <input type="Date" name="witnesseddate">
              </div>
              <div class="report_detai">
                <p>Time of Incident</p>
                <input type="time" name="witnesstime">
              </div>
            </div>
            

            <div class="report_detail">
              <p>Please Describe the Incident</p>
              <textarea name="incidentDescription" required></textarea>
            </div>

            <div class="mixture">
                <div class="report_detai">
                  <p>How many people were involved?</p>
                  <input type="number" name="peopleInvolved">
                </div>
                <div class="report_detai">
                  <p>Were you in any way affected by the incident?</p>
                  <input type="radio" name="ifAffected" value="Yes">
                  <label for="html">Yes</label><br>
                  <input type="radio" name="ifAffected" value="No">
                  <label for="css">No</label><br>
                </div>
            </div>
            

            <!-- AIzaSyDrgDeZC_XKO9aq5nrEeVHaTkLF5Cm-vts -->
            <div class="report_detail">
              <p>Multimedia Attchment</p>
              <input type="file" id="image"  placeholder="Image" name="file" class="entry"  accept="image/*" required><br>
            </div>            
            <div id="map" style="height: 400px;"></div>

            <!-- Coordinates input -->
            <label for="coordinates">Coordinates:</label>
            <input type="text" id="coordinates" name="coordinates" readonly>
            <button type="submit">Submit Report</button>
          </form>
        </div>
    
      </div>
      </div>
    </section>
  <!-- footer section -->
  <Footer class="info_section ">
    <?php
    require_once'Footer.php';
    ?>
  </Footer>
  <!-- footer section -->
  <script src="js/mapAPI.js" defer></script>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>