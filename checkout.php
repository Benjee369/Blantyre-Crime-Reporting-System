<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();

require __DIR__ . "/vendor/autoload.php";
require_once 'DatabaseConn.php';

$stripe_secret_key = "sk_test_51P0hxTEdiO8lrsXZW35QYB0qJUaRKXPeskukHB73OUGsFN9JQf8wJ7Lbw6NSD9wLbL5l9kSKWnVEkSvKEVB2pmlg00FOMLVoZw";

try {
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    // Extract report ID from request
    $report_id = filter_var($_GET['report_id'], FILTER_SANITIZE_NUMBER_INT); // Sanitize input

    if (!$report_id) {
        throw new Exception("Invalid report ID provided.");
    }

    // Prepare database query
    $query = "SELECT c.Incident_Category AS reportCategory, u.First_Name, u.Last_Name, rp.Price
               FROM crimereports c
               INNER JOIN userdetails u ON u.ID = c.UserID
               LEFT JOIN reportprice rp ON rp.Category = c.Incident_Category
               WHERE c.ID = ?
               ORDER BY c.SubmittedDate DESC";

    // Execute the query with prepared statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch report information and price
    $reportInfo = $result->fetch_assoc();

    if (!$reportInfo) {
        throw new Exception("Report not found with ID: $report_id");
    }

    // Extract report details
    $userfirstName = $reportInfo['First_Name'];
    $userlastName = $reportInfo['Last_Name'];
    $reportName = $reportInfo['reportCategory'];
    $unitAmount = $reportInfo['Price'];

    $amount_in_cents = $unitAmount * 100;

    // Create a checkout session with retrieved details
    $checkoutSession = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://localhost/Blantyre_Police_Reporting_System/success.php?report_id=<?php echo $report_id; ?>",
        "cancel_url" => "http://localhost/Blantyre_Police_Reporting_System/Report_History.php",
        "locale" => "auto",
        "line_items" => [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "MWK",
                    "unit_amount" => $amount_in_cents,
                    "product_data" => [
                        "name" => $userfirstName . " " . $userlastName . " - " . $reportName
                    ]                    
                ]
            ]
        ]
    ]);

    // Redirect the user to the checkout session URL
    http_response_code(303);
    header("Location: " . $checkoutSession->url);

} catch (Exception $e) {
    // Handle errors (e.g., display an error message to the user)
    echo "Error: " . $e->getMessage();
    exit();
}
