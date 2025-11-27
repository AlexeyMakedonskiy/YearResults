<?php
// auth.php - обработчик OAuth авторизации
$bot_token = '8535037160:AAGhTQ3qqE8H7OUXiOew_-G0wb59Zy2Egfc';
$auth_data = $_GET;

// Проверяем подпись данных
$check_hash = $auth_data['hash'];
unset($auth_data['hash']);
$data_check_arr = [];
foreach ($auth_data as $key => $value) {
    $data_check_arr[] = $key . '=' . $value;
}
sort($data_check_arr);
$data_check_string = implode("\n", $data_check_arr);
$secret_key = hash('sha256', $bot_token, true);
$hash = hash_hmac('sha256', $data_check_string, $secret_key);

if (strcmp($hash, $check_hash) !== 0) {
    die('Data is NOT from Telegram');
}

if ((time() - $auth_data['auth_date']) > 86400) {
    die('Data is outdated');
}

// Перенаправляем пользователя обратно с данными
$redirect_url = 'https://alexeymakedonskiy.github.io/YearResults/' . urlencode(json_encode($auth_data));
header('Location: ' . $redirect_url);
exit;
?>
