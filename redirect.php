<?php
$merchant_id = "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX";
$amount = $_GET['amount'];
$callback_url = "http://localhost/verify.php";

$data = array(
    "merchant_id" => $merchant_id,
    "amount" => $amount,
    "callback_url" => $callback_url,
    "description" => "خرید پلن از سایت ایده‌سازی حرفه‌ای",
);

$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
$err = curl_error($ch);
$result = json_decode($result, true);

if ($err) {
    echo "خطا در اتصال: " . $err;
} else {
    if ($result['data']['code'] == 100) {
        header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']['authority']);
    } else {
        echo "خطا در درخواست: " . $result['errors']['message'];
    }
}
?>