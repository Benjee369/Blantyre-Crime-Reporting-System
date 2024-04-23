<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help</title>
    
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/faq.css" rel="stylesheet" /> <!-- Include the FAQ CSS file -->
</head>
<body>
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
    <div class="helpbox">
        <div class="container">
        <h1>Help</h1>
        <div class="faq">
            <h2 class="question">How to chat with an officer?</h2>
            <div class="answer">
                <p>After submitting a report, navigate to the Report History page where they find details about their reports, they 
                    then click the chat with officer button which redirects them to a chat interface page containing a message box
                    and a send button. They first write a a message in the text box and then use to senf button to sent the message.</p>
            </div>
        </div>
        <div class="faq">
            <h2 class="question">How to pay?</h2>
            <div class="answer">
                <p>Inorder for a report to be paid for, the report first has to be approved for payment by a Officer assigned to
                    the report. After the officer approves it for payment, the user has to navigate to the report history page
                    where they find details about their previously submitted reports, next to the report is where they find the
                     Pay now button, after clicking it they are redirected to the Stripe payment form, after filling in their card 
                     details they then click the pay button.</p>
            </div>
        </div>
        <div class="faq">
            <h2 class="question">How to create an account?</h2>
            <div class="answer">
                <p>First navigate to the create account page using the navigation bar, the page contains a form that has input fields 
                    that the user has to fill in with their details <b>(Please use an email that actually exists) </b>. After
                 filling in your details, click the Create account button inorder to be registered into the system.</p>
        </div>
        </div>
        <div class="faq">
            <h2 class="question">How to log In?</h2>
            <div class="answer">
                <p>First Navigate to the Login page, here is where you will find two input boxes that say Email address and password, 
                    insert valid login credentials into the fields inorder to login into the system.</p>
            </div>
        </div>
        <div class="faq">
            <h2 class="question">How to use the geographical location feature?</h2>
            <div class="answer">
                <p>When the user is on the police report form, they have to navigate to the page where they find a map, they can then click a location on the map of where there incident
                     happened, and then the location goes into a textbox which then sends the data after the form is submitted</div></p>
        </div>
        <div class="faq">
            <h2 class="question">How to attach multimedia to a report?</h2>
            <div class="answer">
                <p>on the incident report form, navigate to the field that says "Multimedia Attachment", then click the Choose file box which
                    will take you to the devices file manager allowing you to select the wanted media type.</p>
            </div>
        </div>
        <div class="faq">
            <h2 class="question">How print/save a Police report?</h2>
            <div class="answer">
                <p>Navigate to the Report History page, there you will find all the reports that have been submitted. next to the report
                     there is a Print Report button that redirects the user to the page showing the report and a Pint/Save button
                      which allows the user to either save the report as a pdf or print it <output></output>.</p>
            </div>
        </div>
        <div class="faq">
            <h2 class="question">How to contact us?</h2>
            <div class="answer">
                <p>Navigate to the contact us page and fill in the input fields with the appropriate details and press the send button.</p>
            </div>
        </div>
    </div>
    </div>
    
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
  <script src="js/faq.js"></script> <!-- Include the FAQ JavaScript file -->
</body>
</html>
