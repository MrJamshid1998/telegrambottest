<?php

# Принимаем запрос
$data = json_decode(file_get_contents('php://input'), TRUE);
file_put_contents('file.txt', '$data: '.print_r($data, 1)."\n", FILE_APPEND);


//https://api.telegram.org/bot5729087658:AAFM9a2YHsfIGPKBkvN42phEQL4vpEw2oPs/setwebhook?url=https://telegramcamerabot.000webhostapp.com/bot/index.php


# Обрабатываем ручной ввод или нажатие на кнопку
$data1 = $data['callback_query'] ? $data['callback_query'] : $data['message'];

# Важные константы
define('TOKEN', '5729087658:AAFM9a2YHsfIGPKBkvN42phEQL4vpEw2oPs');

# Записываем сообщение пользователя
$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']),'utf-8');


# Обрабатываем сообщение
switch ($message)
{
    case '/start':
        $method = 'sendMessage';
        $send_data = [
            'text'   => 'Siz botni ishga tushirdingiz.'
        ];
        break;
}
# Добавляем данные пользователя

$send_data['chat_id'] = $data['chat']['id'];

$res = sendTelegram($method, $send_data);

function sendTelegram($method, $data, $headers = [])
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers)
    ]);   
    
    $result = curl_exec($curl);
    curl_close($curl);
    return (json_decode($result, 1) ? json_decode($result, 1) : $result);
}