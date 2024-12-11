<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the payment details (like amount and order_id) from the frontend
    $data = json_decode(file_get_contents('php://input'), true);
    $amount = $data['amount'];
    $order_id = $data['order_id'];

    // Set your Airtel Money API credentials here (these should be provided by Airtel)
    $api_key = 'YOUR_AIRTEL_API_KEY';
    $merchant_id = 'YOUR_AIRTEL_MERCHANT_ID';
    $api_url = 'https://api.airtelmoney.com/charge';

    // Prepare payment request data (this is just an example, refer to Airtel API docs)
    $payment_data = [
        'merchant_id' => $merchant_id,
        'order_id' => $order_id,
        'amount' => $amount,
        'currency' => 'MWK', // Example currency, adjust based on your region
        'callback_url' => 'https://yourwebsite.com/payment-callback',
    ];

    // Make the API request to Airtel Money
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
    ]);

    // Execute request and get response
    $response = curl_exec($ch);
    curl_close($ch);

    // Handle the response from Airtel Money
    if ($response) {
        $response_data = json_decode($response, true);
        if ($response_data['status'] == 'success') {
            // Redirect the user to Airtel Money's payment gateway
            echo json_encode(['payment_url' => $response_data['payment_url']]);
        } else {
            // Handle error
            echo json_encode(['error' => 'Failed to initiate payment']);
        }
    } else {
        echo json_encode(['error' => 'No response from Airtel Money API']);
    }
}
?>
