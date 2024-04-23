<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION["isloggedin"])) {
    header("Location: Admin-Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <title>Manage Users</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>
<body>
    <!-- nav2 -->
    <header class="header_section">
    <?php
    require_once'nvbr.php'; 
    ?>
    </header>
        <!-- nav2 end -->   
    <div class="main-wrapper">
        <!-- side bar thing -->
        <?php
        require_once 'side-bar.php';
        ?>
        <!-- end side bar thing -->

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                </div>
                
                <div class="row">
                    <div class="main-card-thing">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title d-inline-block">View and Manage Users</h4>
                            </div>
                            <div class="user_details">
                            <?php
                            require_once 'DatabaseConn.php';

                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
                                $user_id = $_POST['user_id'];

                                // Prepare a DELETE statement
                                $delete_query = "DELETE FROM userdetails WHERE ID = ?";
                                $delete_stmt = $conn->prepare($delete_query);
                                $delete_stmt->bind_param("i", $user_id);

                                // Execute the DELETE statement
                                if ($delete_stmt->execute()) {
                                    echo '<div class="alert alert-success" role="alert">User deleted successfully</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Error deleting user</div>';
                                }

                                // Close the prepared statement
                                $delete_stmt->close();
                            }

                            $query = "SELECT * FROM userdetails";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($user_detail = $result->fetch_assoc()) {
                                    echo '<div class="u_details">';
                                    echo '<h1>' . $user_detail['First_Name'] . ' ' . $user_detail['Last_Name'] . '</h1>';
                                    echo '<hr class="line-thing">';
                                    echo '<p><b>Email:</b> ' . $user_detail['Email_Address'] . '</p>';
                                    echo '<hr class="line-thing">';
                                    echo '<p><b>Phone Number:</b> ' . $user_detail['Phone_Number'] . '</p>';
                                    echo '<hr class="line-thing">';
                                    echo '<p><b>Location:</b> ' . $user_detail['Address'] . '</p>';
                                    echo '<form method="post">';
                                    echo '<input type="hidden" name="user_id" value="' . $user_detail['ID'] . '">';
                                    echo '<button type="submit" name="delete_user" class="btn btn-outline-primary take-btn">Delete User</button>';
                                    echo '</form>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p class="no_review">No users available in the system as of now</p>';
                            }

                            // Close the prepared statement and database connection
                            $stmt->close();
                            $conn->close();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
