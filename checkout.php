<?php

require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51P0hxTEdiO8lrsXZW35QYB0qJUaRKXPeskukHB73OUGsFN9JQf8wJ7Lbw6NSD9wLbL5l9kSKWnVEkSvKEVB2pmlg00FOMLVoZw";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/guader-html/success.php",
    "cancel_url" => "http://localhost/guader-html/Report_History.php",
    "locale" => "auto",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => 2000,
                "product_data" => [
                    "name" => "T-shirt"
                ]
            ]
        ],
        [
            "quantity" => 2,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => 700,
                "product_data" => [
                    "name" => "Hat"
                ]
            ]
        ]        
    ]
]);

http_response_code(303);
header("Location: " . $checkout_session->url);
