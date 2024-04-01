<?php
session_start();
if (isset($_POST['message'], $_POST['report_id'])) {

  $message = $_POST['message'];
  $report_id = $_POST['report_id'];

  if (empty($message)) {
    echo "Error: Please enter a message.";
    exit();
  }

  try {
    require_once 'DatabaseConn.php';

    $null = 0;
    $sender_type = isset($_SESSION['officer_id']) ? 'officer' : 'user';
    $sender_id = ($sender_type === 'officer') ? $_SESSION['officer_id'] : $_SESSION['user_id'];

    $query = "INSERT INTO chats (report_id, user_id, officer_id, message, sender_type, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);

    if ($sender_type === 'officer') {
        $stmt->bind_param("iiisi", $report_id, $null, $sender_id, $message, $sender_type);
    } else {
        $stmt->bind_param("iiisi", $report_id, $sender_id, $null, $message, $sender_type);
    }

    if ($stmt->execute()) {
        header("Location: chat_interface.php?report_id=$report_id");
        exit();
    } else {
        echo "Error sending message: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();

  } catch(Exception $e) {
    echo "Error: " . $e->getMessage();
  }

} elseif (isset($_GET['report_id'])) {
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    

    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>
<body>
    <header class="header_section">
    <?php
    require_once 'nvbr.php'; 
    ?>
    </header>
    <main class="">


        <?php
        if(isset($_SESSION['officer_id'])){
        require_once 'officer_side_bar.php';
        }
        ?>
        <main class="chat-body">
        <div class="chat-text" id="chat-text">
            <?php
            require_once 'DatabaseConn.php';

            $report_id = $_GET['report_id'];

            $query = "SELECT * FROM chats WHERE report_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $report_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                if ($row['user_id'] !== null) {
                    $sender_name = "User";
                    $messageClass = 'user-message';
                } elseif ($row['officer_id'] !== null) {
                    $sender_name = "Officer";
                    $messageClass = 'officer-message';
                } else {
                    $sender_name = "Unknown";
                    $messageClass = 'unknown-message';
                }

                echo '<div class="chat-message ' . $messageClass . '">';
                echo '<b class="chat-message-sender"> ' . $sender_name . '</b>';
                echo '<p class="the-chat-message">' . $row['message'] . '</p>';
                echo '<span class="chat-message-timestamp">' . $row['created_at'] . '</span>';
                echo '</div>';
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
        

    <form action="chat_interface.php" method="post" class="form-chat" id="chat-form">
        <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
        <textarea name="message" placeholder="Type your message here" required></textarea>
        <button type="submit" id="chat-button" >Send</button>
    </form>
    </main>
    </main>
    <?php
    if(isset($_SESSION['user_id'])){
    ?>
        <Footer class="info_section">
            <?php
            require_once 'Footer.php';
            ?>
        </Footer>
    <?php
    }
    ?>

    <script>
        function refreshChat() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var messages = JSON.parse(this.responseText); // Parse the JSON response
            var chatText = document.getElementById("chat-text");
            chatText.innerHTML = ""; // Clear previous messages
            
            messages.forEach(function(message) {
                var senderName = (message.user_id !== null) ? "User" : "Officer";
                var messageClass = (message.user_id !== null) ? "user-message" : "officer-message";
                
                var chatMessage = document.createElement("div");
                chatMessage.classList.add("chat-message", messageClass);
                chatMessage.innerHTML = '<b class="chat-message-sender">' + senderName + '</b>' +
                                         '<p class="the-chat-message">' + message.message + '</p>';
                
                chatText.appendChild(chatMessage); // Append message to chat text
            });
        }
    };
    xhttp.open("GET", "refresh.php?report_id=<?php echo $report_id; ?>", true);
    xhttp.send();
}

// Call refreshChat initially
refreshChat();

// Refresh chat every 2 seconds
setInterval(refreshChat, 2000);

    </script>
</body>
</html>


    <?php

} else {
    echo "Invalid request.";
    exit();
}
?>
