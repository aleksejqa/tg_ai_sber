<?php
//Данный скрипт несёт исключительно ознакомительный характер

$content = file_get_contents("php://input");
$update = json_decode($content, TRUE);

$message = $update["message"];
$text = $message["text"];

if ($update["callback_query"]["message"]["chat"]["id"]>0){
$chatId = $update["callback_query"]["message"]["chat"]["id"];
$data =   $update["callback_query"]["data"];
$msId=    $update["callback_query"]["message"]["message_id"];
} else {	
$chatId = $message["chat"]["id"];
}


if ($text=="/start"){ sms_tg($chatId,"Вышлите начало текста, а искуственный интелект продолжит его.");
exit;}

$url = "https://api..ru/v2/aicloud/gpt3";
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => 'OPTIONS',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => 1,
    CURLOPT_NOBODY => true,
    CURLOPT_VERBOSE => 0,
));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$r = curl_exec($ch);
curl_close($ch);




$headers = [
'Host: api..ru',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36',
'DNT: 1',
'Content-Type: application/json;charset=utf-8',
'Accept: */*',
'Origin: https://.ru',
'Sec-Fetch-Site: same-site',
'Sec-Fetch-Mode: cors',
'Sec-Fetch-Dest: empty',
'Referer: https://.ru/',
'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,cy;q=0.6,pt;q=0.5',
];


$zaprs=$text;
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"question":"'.$zaprs.'"}');
$output = curl_exec($ch);
curl_close($ch);

$resultsss= json_decode($output, true)['data'];





function sms_tg($user, $content)
{
	$chtg = curl_init();
$botToken="16767:AAF-RokcZDUo3A";
$type = 'text';
curl_setopt($chtg, CURLOPT_URL, "https://api.telegram.org/bot".$botToken."/sendmessage");
curl_setopt($chtg,CURLOPT_TCP_KEEPALIVE,TRUE);
curl_setopt_array($chtg, array(
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POST => true,
CURLOPT_HEADER => false,
CURLOPT_HTTPHEADER => array('Host: api.telegram.org','Content-Type: multipart/form-data'),
CURLOPT_POSTFIELDS => array(
            'chat_id' => $user,'reply_markup' => '',
			'disable_web_page_preview' => 'true','parse_mode'=>'Markdown',
            $type => $content
        ),
CURLOPT_TIMEOUT => 0,
CURLOPT_CONNECTTIMEOUT => 6000,
CURLOPT_SSL_VERIFYPEER => false
));
$html =  curl_exec($chtg);
return $html;//echo $html;
}



sms_tg($chatId,$text.$resultsss);
