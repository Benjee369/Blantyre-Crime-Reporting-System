<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
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
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
    <main class="history">
       <h1>Chat Interface</h1>
    
    <!-- Display relevant details of the report or incident -->
    <div>
        <h2>Report Details</h2>
        <!-- Include relevant report details here -->
    </div>
    
    <!-- Chat messages container -->
    <div id="chatMessages">
        <!-- Display chat messages here -->
    </div>
    
    <!-- Input field for typing and sending messages -->
    <div>
        <input type="text" id="messageInput" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>
    
    <!-- Include any necessary JavaScript files, such as for handling real-time updates -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.js"></script>
    <script>
        // JavaScript code for handling real-time updates and sending messages
        // Define functions like sendMessage() to handle user interactions
    </script> 
    </main>
    
    <Footer class="info_section">
    <?php
    require_once 'Footer.php';
    ?>
  </Footer>
</body>
</html>
