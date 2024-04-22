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
    require_once'nvbr.php'; 
    ?>
    </header>
    <div class="main-wrapper">
        <?php
        require_once 'side-bar.php';
        ?>
<div class="assign-officer">

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'DatabaseConn.php';

    $report_id = $_POST['report_id'];
    $officer_id = $_POST['officer_id'];
    $priority_level = $_POST['priority_level'];
    $assigned_date = date("Y-m-d H:i:s");

    //Code to assign select offficer to specific report
    $query = "INSERT INTO assignments (ReportID, OfficerID, PriorityLevel, Status, AssignedDate) VALUES (?, ?, ?, 'In Progress', ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $report_id, $officer_id, $priority_level, $assigned_date);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>Assignment successfully created. Go back to the <a href='Admin_Side.php'>Dashboard<a/></p>";
    } else {
        echo "Error creating assignment: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: report_details.php?report_id=$report_id");
    exit();
}
?>
</div>
    </div>
</body>
</html>

