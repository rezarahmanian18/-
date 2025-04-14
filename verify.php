<?php
$merchant_id = "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX";
$authority = $_GET['Authority'];
$status = $_GET['Status'];

if ($status == 'OK') {
    $data = array("merchant_id" => $merchant_id, "authority" => $authority, "amount" => 49000);
    $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    $result = json_decode($result, true);
    if ($result['data']['code'] == 100) {
        echo "<div style='padding: 30px; font-size: 1.5rem;'>✅ پرداخت موفق بود. شماره تراکنش: " . $result['data']['ref_id'] . "</div>";
    } else {
        echo "<div style='color:red;'>❌ خطا در پرداخت: " . $result['errors']['message'] . "</div>";
    }
} else {
    echo "<div style='color:red;'>❌ پرداخت توسط کاربر لغو شد.</div>";
}
?>