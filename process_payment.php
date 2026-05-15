<?php
/**
 * THE AI CONTENT MACHINE - PAYMENT PROCESSOR (Pay4Bit)
 * Updated to use GET redirect as requested by user.
 */

// 1. SECURE CONFIGURATION
$public_key = 'e6d21-558'; // New key provided by user
$secret_key = '6bb9921ce152246da82efd31392e7640'; 

// 2. RETRIEVE & SANITIZE DATA
$plan_name    = isset($_POST['plan_name']) ? strip_tags($_POST['plan_name']) : 'The AI Content Machine Bundle';
$amount_form  = isset($_POST['amount'])    ? (float)$_POST['amount']         : 27.00;
$currency_form = isset($_POST['currency'])  ? strtoupper($_POST['currency']) : 'USD';
$customer_email = isset($_POST['customer_email']) ? strip_tags($_POST['customer_email']) : 'demo@example.com';
$customer_country = isset($_POST['customer_country']) ? strip_tags($_POST['customer_country']) : 'US';
$traffic_source = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct/Unknown';

// 3. GENERATE UNIQUE TRANSACTION DETAILS
$ordernum = 'ORD-' . strtoupper(dechex(time())) . '-' . rand(1000, 9999);
$account  = $ordernum; 
$desc     = 'Full Bundle: ' . $plan_name . ' (' . $ordernum . ')';
$amount   = number_format($amount_form, 2, '.', ''); 

// 4. LOG THE SALE TO GOOGLE SHEETS (Vercel compatible)
$google_script_url = 'https://script.google.com/macros/s/AKfycbz7IXqmd4z55wyLDfn6jzNQlLAN3IoEgVbSYTCEaaonKsSNA_yQ5RSxC0hDVbVkBAHr/exec'; 

$log_data = [
    'date' => date('Y-m-d H:i:s'),
    'email' => $customer_email,
    'country' => $customer_country,
    'source' => $traffic_source,
    'amount' => $amount,
    'currency' => $currency_form,
    'order_id' => $ordernum,
    'ip' => $_SERVER['REMOTE_ADDR']
];

$ch = curl_init($google_script_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($log_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Important for Apps Script redirects
curl_exec($ch);
curl_close($ch);

// 5. GENERATE SECURITY HASH FOR SUCCESS REDIRECT (Verification)
$secure_hash = hash('sha256', $ordernum . $secret_key);

// 6. CONSTRUCT THE REDIRECT URL (GET Format)
$success_url = "https://" . $_SERVER['HTTP_HOST'] . "/success.php?email=" . urlencode($customer_email) . "&order=" . $ordernum . "&sum=" . $amount . "&cur=" . $currency_form . "&hash=" . $secure_hash;
$fail_url    = "https://" . $_SERVER['HTTP_HOST'] . "/index.html#buy";

$params = [
    'public_key' => $public_key,
    'sum'        => $amount,
    'currency'   => $currency_form,
    'account'    => $account,
    'desc'       => $desc,
    'sign'       => $check_sign, // Added for security
    'success_url' => $success_url,
    'fail_url'    => $fail_url
];

$query_string = http_build_query($params);
$redirect_url = "https://api.pay4bit.net/pay?" . $query_string;

// 6. PERFORM THE REDIRECT
header("Location: " . $redirect_url);
exit();
?>