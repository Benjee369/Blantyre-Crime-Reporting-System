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
        $stmt->bind_param("iiisi", $report_id, $null, $sender_id, $message, $sender_type); // Use null as a placeholder value
    } else {
        $stmt->bind_param("iiisi", $report_id, $sender_id, $null, $message, $sender_type); // Use null as a placeholder value
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
        <link href="css/responsive.css" rel="stylesheet" />
    </head>
    <body>
        <header class="header_section">
        <?php
        require_once'nvbr.php'; 
        ?>
        </header>
        <main class="chat-body">
        <?php
        

            require_once 'DatabaseConn.php';
        
            $report_id = $_GET['report_id'];
        
            $query = "SELECT * FROM chats WHERE report_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $report_id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            while ($row = $result->fetch_assoc()) {
                $sender_label = ($row['sender_type'] == 0) ? 'Officer' : 'User';
                $sender_id = $row['user_id'];
        
                $sender_query = "SELECT First_Name, Last_Name FROM userdetails WHERE ID = ?";
                $sender_stmt = $conn->prepare($sender_query);
                $sender_stmt->bind_param("i", $sender_id);
                $sender_stmt->execute();
                $sender_result = $sender_stmt->get_result();
                $sender_row = $sender_result->fetch_assoc();
                $sender_name = $sender_row ? $sender_row['First_Name'] . ' ' . $sender_row['Last_Name'] : 'Officer';
        
                echo '<div class="chat-message">';
                echo '<p class="chat-message-sender">' . $sender_label . ': ' . $sender_name . '</p>';
                echo '<p class="the-chat-message">' . $row['message'] . '</p>';
                echo '<span class="chat-message-timestamp">' . $row['created_at'] . '</span>';
                echo '</div>';
            }
        
            $stmt->close();
            $conn->close();
        ?>
        <form action="chat_interface.php" method="post">
            <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
            <textarea name="message" placeholder="Type your message here" required></textarea>
            <button type="submit" id="chat-button" >Send</button>
        </form>
        </main>
        <Footer class="info_section">
        <?php
        require_once 'Footer.php';
        ?>
        </Footer>
    </body>
    <script>
        window.onload = function() {
            // Scroll to the chat button
            var chatButton = document.getElementById('chat-button');
            if (chatButton) {
                chatButton.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };
    </script>
    </html>
    <?php

} else {
    echo "Invalid request.";
    exit();
}
?>
