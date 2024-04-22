<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Admin Dashboard</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap2.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>

<body>
    <!-- Header -->
    <header class="header_section">
    <?php require_once 'nvbr.php'; ?>
    </header>
    <!-- Header end -->

    <div class="main-wrapper">
        <!-- Side bar -->
        <?php require_once 'side-bar.php'; ?>
        <!-- Side bar end -->

        <div class="page-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <button class="generatebtn" id="createReport" onclick="generateReport()">Generate Officer report</button>
                            <div id="reportContainer"></div>
                            <button id="printReport" class="btn btn-primary float-right">Print/Save Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function generateReport() {
        // Send AJAX request to generate report
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "generate-report.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse JSON response
                    var response = JSON.parse(xhr.responseText);
                    // Display the generated report in a table
                    displayOfficers(response.officers);
                } else {
                    console.error("Failed to generate report: " + xhr.statusText);
                }
            }
        };
        xhr.send(); // No data needs to be sent in this case
    }

    function displayOfficers(officers) {
        // Get the report container element
        var reportContainer = document.getElementById("reportContainer");

        // Clear any existing content
        reportContainer.innerHTML = "";

        // Create a table element
        var table = document.createElement("table");
        table.classList.add("table");

        // Create the table header row
        var headerRow = table.insertRow();
        var headers = ["Officer ID", "First Name", "Last Name", "Report Count"];
        headers.forEach(function(header) {
            var headerCell = document.createElement("th");
            headerCell.textContent = header;
            headerRow.appendChild(headerCell);
        });

        // Create the table rows and populate with officer data
        officers.forEach(function(officer) {
            var row = table.insertRow();
            for (var key in officer) {
                if (officer.hasOwnProperty(key)) {
                    var cell = row.insertCell();
                    cell.textContent = officer[key];
                }
            }
        });

        // Append the table to the report container
        reportContainer.appendChild(table);
    }
</script>
<script>
        document.getElementById("printReport").addEventListener("click", function() {
        printReport();
        });

        function printReport() {
            var printWindow = window.open('', '_blank');
            var reportContent = document.getElementById("reportContainer").innerHTML;
            var styles = document.head.getElementsByTagName("link");
            var styleContent = '';
            for (var i = 0; i < styles.length; i++) {
                if (styles[i].rel === "stylesheet") {
                    styleContent += styles[i].outerHTML;
                }
            }
            printWindow.document.write('<html><head><title>Report</title>' + styleContent + '</head><body>' + reportContent + '</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        </script>

</body>
</html>
