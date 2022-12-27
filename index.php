<?php

$curl = curl_init('https://www.cbr.ru/scripts/XML_daily.asp?date_req=');

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HEADER, false);

$html = curl_exec($curl);
$xml = new SimpleXMLElement($html);
foreach($xml->children() as $second_gen)
{
  $Mess=0;
  if($second_gen->CharCode=="USD" or $second_gen->CharCode=="EUR" and $Mess <=2 )
  {
    ?>
    <html><br></html>
    <?php
    $text = $second_gen->CharCode.':'. $second_gen->Value;
    $botToken="5822878086:AAGf7PI3Y5KHz9QpHRQeV0tsTXVtQrlsNII";

    $website= "https://api.telegram.org/bot". $botToken;
    $chatId= -846620747;  
    $params=[
      'chat_id'=>$chatId, 
      'text'=> $text,
    ];
    $ch = curl_init($website . '/sendMessage');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    echo $result;
    curl_close($ch);
    $Mess+=1;
}
}
curl_close($curl);